--++++++++++++++++++++++ START 04/11/2022 V.11.00.00 +++++++++++++++++++++++++++++++++

IF EXISTS
(SELECT * FROM dbo.sysobjects WHERE id = object_id(N'STP_PRCxPreparePdtSale')and OBJECTPROPERTY(id, N'IsProcedure') = 1)
DROP PROCEDURE [dbo].STP_PRCxPreparePdtSale
GO
CREATE PROCEDURE [dbo].STP_PRCxPreparePdtSale
 @ptBchCode varchar(5)
,@ptMerCode varchar(10) 
,@ptShpCode varchar(5)
,@ptPplCode varchar(20)
,@ptFmt varchar(10) /*Arm 64-01-08 (CR) Format */
,@pnLang INT
,@FNResult INT OUTPUT AS
/*---------------------------------------------------------------------
Document History
Version		Date			User	Remark
00.01.00	22/04/2020	Em		create  
00.02.00	23/04/2020	Em		แก้ไขปรับปรุง
00.03.00	28/04/2020	Em		แก้ไขปรับปรุง
00.04.00	28/04/2020	Em		แก้ไขปรับปรุง
00.05.00	15/05/2020	Em		เพิ่มฟิลด์ FTPdtStaVat
00.06.00	04/06/2020	Em		เปลี่ยนไปใช้ FTNameAbb
04.01.00	06/07/2020	Em		ตั้งต้น SKC
04.02.00	14/07/2020	Em		เพิ่มฟิลด์ FTPdtStkControl,FTPdtPoint
04.03.00	23/09/2020	Em		แก้ไขชื่อสินค้าให้ใช้จาก PdtName
04.04.00	08/01/2021	Arm		(CR) การแสดงกลุ่มส่วนลดรายสินค้า [A,B,C] ในหน้าการขาย
04.05.00	08/01/2021	Net		แก้ไขเพิ่มตรวจสอบ Merchant ในกรีที่ไม่ได้กำหนด Shp
			08/01/2021	Net		เพิ่มฟิลด์  FTPgpChain,FTPtyCode,FTClrCode,FTPszCode,FTPbnCode,FTPmoCode
04.06.00	26/08/2022	Arm		เพิ่ม FTPdtRefID, FTCtyCode / Get ชื่อสินค้าลง TPSMPdt_L
04.07.00	08/10/2022	Arm		เพิ่ม FTVatCode,FCPdtVatRate
----------------------------------------------------------------------*/
BEGIN TRY

	TRUNCATE TABLE TPSMPdt

	IF(ISNULL(@ptShpCode,'') = '') BEGIN
		INSERT INTO TPSMPdt(FTPdtCode,FTBarCode,FTPdtName,FTPunName,FTPunCode,FCPdtUnitFact,FCPdtPrice,FTPdtSaleType,FTPdtStaAlwDis,FTPdtPicPath,FTTcgCode,FTPdtStaVat,FTPgpChain,FTPdtStkControl,FTPdtPoint--)	-- 04.02.00 --
			,FTPtyCode,FTClrCode,FTPszCode,FTPbnCode,FTPmoCode --04.05.00--
			,FTPdtRefID, FTCtyCode -- 04.06.00 --
			,FTVatCode, FCPdtVatRate) -- 04.07.00 --
		SELECT DISTINCT PDT.FTPdtCode,PBR.FTBarCode, 
		--ISNULL(PDL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)) AS FTPdtName, -- 04.03.00 -- /*Arm 64-01-08 Comment Code */
		
		/*Arm 64-01-08 (CR) การแสดงกลุ่มส่วนลดรายสินค้า [A,B,C] ในหน้าการขาย */
		CASE WHEN ISNULL(@ptFmt,'') = 'SKC' AND ISNULL(PDL.FTPdtNameOth,'') != '' THEN '['+ PDL.FTPdtNameOth +'] '+ ISNULL(PDL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode))
		ELSE ISNULL(PDL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)) END AS FTPdtName ,
		/*+++++++++++*/
		
		--ISNULL(PDL.FTPdtNameABB,(SELECT TOP 1 FTPdtNameABB FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)) AS FTPdtName, -- 6. --
		ISNULL(PUL.FTPunName,(SELECT TOP 1 FTPunName FROM TCNMPdtUnit_L WITH(NOLOCK) WHERE FTPunCode = PPS.FTPunCode)) AS FTPunName, 
		PPS.FTPunCode, PPS.FCPdtUnitFact,ISNULL(GrpPri.FCpdtPrice,PDTPri.FCpdtPrice) AS FCPdtPrice, PDT.FTPdtSaleType,
		PDT.FTPdtStaAlwDis,IMG.FTImgObj,PDT.FTTcgCode,PDT.FTPdtStaVat,
		PDT.FTPgpChain,	-- 04.01.00 --
		PDT.FTPdtStkControl,PDT.FTPdtPoint,	-- 04.02.00 --
		PDT.FTPtyCode,PPS.FTClrCode,PPS.FTPszCode,PDT.FTPbnCode,PDT.FTPmoCode,  --04.05.00--
		PDT.FTPdtRefID, PDT.FTCtyCode, -- 04.06.00 --
		PDT.FTVatCode, ISNULL((SELECT TOP 1 FCVatRate FROM TCNMVatRate WITH(NOLOCK) WHERE FTVatCode = PDT.FTVatCode AND CONVERT(VARCHAR(10),FDVatStart,121) < CONVERT(VARCHAR(10),GETDATE(),121)  ORDER BY FDVatStart DESC),0) AS FCPdtVatRate -- 04.07.00 --
		FROM TCNMPdt PDT WITH(NOLOCK) 
		LEFT JOIN TCNMPdt_L PDL WITH(NOLOCK) ON PDT.FTPdtCode = PDL.FTPdtCode AND PDL.FNLngID = @pnLang
		INNER JOIN TCNMPdtPackSize PPS WITH(NOLOCK) ON PDT.FTPdtCode = PPS.FTPdtCode 
		LEFT JOIN TCNMPdtSpcBch PSB WITH(NOLOCK) ON PSB.FTPdtCode = PDT.FTPdtCode
		LEFT JOIN TCNMPdtUnit_L PUL WITH(NOLOCK) ON PPS.FTPunCode = PUL.FTPunCode AND PUL.FNLngID = @pnLang
		INNER JOIN TCNMPdtBar PBR WITH(NOLOCK) ON PDT.FTPdtCode = PBR.FTPdtCode AND PBR.FTBarStaUse = '1' AND PBR.FTBarStaAlwSale = '1' 
		AND PPS.FTPunCode = PBR.FTPunCode AND PBR.FTBarStaUse = '1' 
		LEFT JOIN TCNMImgPdt IMG WITH(NOLOCK) ON PDT.FTPdtCode = IMG.FTImgRefID AND IMG.FTImgKey = 'master' AND IMG.FNImgSeq = '1'
			AND IMG.FTImgTable = 'TCNMPdt'
		LEFT JOIN  TPSTPdtPrice PDTPri WITH(NOLOCK) ON PDT.FTPdtCode = PDTPri.FTPdtCode 
			AND PPS.FTPunCode = PDTPri.FTPunCode AND (ISNULL(PDTPri.FTPplCode,'') = '')
			AND PDTPri.FTPriType = '1'	-- 3. --
		LEFT JOIN  TPSTPdtPrice GrpPri WITH(NOLOCK) ON PDT.FTPdtCode = GrpPri.FTPdtCode
			AND PPS.FTPunCode = GrpPri.FTPunCode AND (ISNULL(GrpPri.FTPplCode,'') = @ptPplCode)
			AND GrpPri.FTPriType = '1'	-- 4. --

		WHERE (PDT.FTPdtForSystem = '1' OR (PDT.FTPdtForSystem = '4' AND PDT.FTPdtType = '2' AND PDT.FTPdtSaleType = '2')) 
		AND (PSB.FTBchCode = @ptBchCode OR ISNULL(PSB.FTBchCode,'') = '')
		--AND ISNULL(PSB.FTMerCode,'') ='' AND ISNULL(PSB.FTShpCode,'') = ''
		AND (ISNULL(PSB.FTMerCode,'') = @ptMerCode OR ISNULL(PSB.FTMerCode,'') = '') -- 04.05.00 --
		AND ISNULL(PSB.FTShpCode,'') = ''
	
	END
	ELSE BEGIN
		INSERT INTO TPSMPdt(FTPdtCode,FTBarCode,FTPdtName,FTPunName,FTPunCode,FCPdtUnitFact,FCPdtPrice,FTPdtSaleType,FTPdtStaAlwDis,FTPdtPicPath,FTTcgCode,FTPdtStaVat,FTPgpChain,FTPdtStkControl,FTPdtPoint--)	-- 04.02.00 --
			,FTPtyCode,FTClrCode,FTPszCode,FTPbnCode,FTPmoCode --04.05.00--
			,FTPdtRefID, FTCtyCode -- 04.06.00 --
			,FTVatCode, FCPdtVatRate) -- 04.07.00 --
		SELECT DISTINCT PDT.FTPdtCode,PBR.FTBarCode, 
		--ISNULL(PDL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)) AS FTPdtName,	-- 04.03.00 -- /*Arm 64-01-08 Comment Code */
		
		/*Arm 64-01-08 (CR) การแสดงกลุ่มส่วนลดรายสินค้า [A,B,C] ในหน้าการขาย */
		CASE WHEN ISNULL(@ptFmt,'') = 'SKC' AND ISNULL(PDL.FTPdtNameOth,'') != '' THEN '['+ PDL.FTPdtNameOth +'] '+ ISNULL(PDL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode))
		ELSE ISNULL(PDL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)) END AS FTPdtName ,
		/*+++++++++++*/
		
		--ISNULL(PDL.FTPdtNameABB,(SELECT TOP 1 FTPdtNameABB FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)) AS FTPdtName, -- 6. --
		ISNULL(PUL.FTPunName,(SELECT TOP 1 FTPunName FROM TCNMPdtUnit_L WITH(NOLOCK) WHERE FTPunCode = PPS.FTPunCode)) AS FTPunName, 
		PPS.FTPunCode, PPS.FCPdtUnitFact,ISNULL(GrpPri.FCpdtPrice,PDTPri.FCpdtPrice) AS FCPdtPrice, PDT.FTPdtSaleType,
		PDT.FTPdtStaAlwDis,IMG.FTImgObj,PDT.FTTcgCode,PDT.FTPdtStaVat,
		PDT.FTPgpChain,	-- 04.01.00 --
		PDT.FTPdtStkControl,PDT.FTPdtPoint,	-- 04.02.00 --
		PDT.FTPtyCode,PPS.FTClrCode,PPS.FTPszCode,PDT.FTPbnCode,PDT.FTPmoCode, -- 04.05.00 --
		PDT.FTPdtRefID, PDT.FTCtyCode, -- 04.06.00 --
		PDT.FTVatCode, ISNULL((SELECT TOP 1 FCVatRate FROM TCNMVatRate WITH(NOLOCK) WHERE FTVatCode = PDT.FTVatCode AND CONVERT(VARCHAR(10),FDVatStart,121) < CONVERT(VARCHAR(10),GETDATE(),121)  ORDER BY FDVatStart DESC),0) AS FCPdtVatRate -- 04.07.00 --
		FROM TCNMPdt PDT WITH(NOLOCK) 
		LEFT JOIN TCNMPdt_L PDL WITH(NOLOCK) ON PDT.FTPdtCode = PDL.FTPdtCode AND PDL.FNLngID = @pnLang
		INNER JOIN TCNMPdtPackSize PPS WITH(NOLOCK) ON PDT.FTPdtCode = PPS.FTPdtCode 
		INNER JOIN TCNMPdtSpcBch PSB WITH(NOLOCK) ON PSB.FTPdtCode = PDT.FTPdtCode
		LEFT JOIN TCNMPdtUnit_L PUL WITH(NOLOCK) ON PPS.FTPunCode = PUL.FTPunCode AND PUL.FNLngID = @pnLang
		INNER JOIN TCNMPdtBar PBR WITH(NOLOCK) ON PDT.FTPdtCode = PBR.FTPdtCode AND PBR.FTBarStaUse = '1' AND PBR.FTBarStaAlwSale = '1' 
		AND PPS.FTPunCode = PBR.FTPunCode AND PBR.FTBarStaUse = '1' 
		LEFT JOIN TCNMImgPdt IMG WITH(NOLOCK) ON PDT.FTPdtCode = IMG.FTImgRefID AND IMG.FTImgKey = 'master' AND IMG.FNImgSeq = '1'
			AND IMG.FTImgTable = 'TCNMPdt'
		LEFT JOIN  TPSTPdtPrice PDTPri WITH(NOLOCK) ON PDT.FTPdtCode = PDTPri.FTPdtCode 
			AND PPS.FTPunCode = PDTPri.FTPunCode AND (ISNULL(PDTPri.FTPplCode,'') = '')
			AND PDTPri.FTPriType = '1'	-- 3. --
		LEFT JOIN  TPSTPdtPrice GrpPri WITH(NOLOCK) ON PDT.FTPdtCode = GrpPri.FTPdtCode
			AND PPS.FTPunCode = GrpPri.FTPunCode AND (ISNULL(GrpPri.FTPplCode,'') = @ptPplCode)
			AND GrpPri.FTPriType = '1'	-- 4. --

		WHERE (PDT.FTPdtForSystem = '1' OR (PDT.FTPdtForSystem = '4' AND PDT.FTPdtType = '2' AND PDT.FTPdtSaleType = '2')) 
		AND (ISNULL(PSB.FTBchCode,'') = @ptBchCode OR ISNULL(PSB.FTBchCode,'') = '')
		AND ((ISNULL(PSB.FTMerCode,'') = @ptMerCode AND ISNULL(PSB.FTShpCode,'') ='')
		OR (ISNULL(PSB.FTMerCode,'') = @ptMerCode AND ISNULL(PSB.FTShpCode,'') = @ptShpCode))
	END
	
	UPDATE TPSMPdt
	SET FCPdtPrice = 0
	WHERE FCPdtPrice IS NULL AND FTPdtSaleType = '2'

	DELETE TPSMPdt WHERE FCPdtPrice IS NULL

	IF OBJECT_ID(N'TPSMPdt_L') IS NULL BEGIN
		SELECT FTPdtCode,FTPdtName,FTPdtNameABB 
		INTO TPSMPdt_L
		FROM TCNMPdt_L
		WHERE 1 = 2
	END

	TRUNCATE TABLE TPSMPdt_L

	INSERT INTO TPSMPdt_L
	--SELECT FTPdtCode,FTPdtName,FTPdtNameABB /*Arm 64-01-08 Comment Code */

	-- 04.06.00 Comment Code --
	--SELECT FTPdtCode,
	--/*Arm 64-01-08 (CR) การแสดงกลุ่มส่วนลดรายสินค้า [A,B,C] ในหน้าการขาย */
	--CASE WHEN ISNULL(@ptFmt,'') = 'SKC' AND ISNULL(FTPdtNameOth,'') != '' THEN '['+ FTPdtNameOth +'] '+ FTPdtName
	--ELSE FTPdtName END AS FTPdtName,
	--FTPdtNameABB
	--/*+++++++++++*/
	--FROM TCNMPdt_L
	--WHERE FNLngID = @pnLang
	-- 04.06.00 Comment Code --

	-- 04.06.00 --
	SELECT DISTINCT PDT.FTPdtCode 
	, CASE  WHEN ISNULL(@ptFmt,'') = 'SKC' THEN 
			CASE WHEN ISNULL(PDTL.FTPdtName,'') = '' THEN  
					(SELECT TOP 1 CASE WHEN ISNULL(FTPdtNameOth,'') != '' THEN '['+ FTPdtNameOth +'] '+ FTPdtName ELSE FTPdtName END FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)
				ELSE CASE WHEN ISNULL(FTPdtNameOth,'') != '' THEN '['+ PDTL.FTPdtNameOth +'] '+ PDTL.FTPdtName ELSE PDTL.FTPdtName END
			END
			ELSE ISNULL(PDTL.FTPdtName,(SELECT TOP 1 FTPdtName FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode))
		END AS FTPdtName

	, CASE WHEN ISNULL(PDTL.FTPdtName,'') = '' THEN (SELECT TOP 1 FTPdtNameABB FROM TCNMPdt_L WITH(NOLOCK) WHERE FTPdtCode = PDT.FTPdtCode)
			ELSE PDTL.FTPdtNameABB 
		END AS FTPdtNameABB
	FROM TPSMPdt PDT
	LEFT JOIN TCNMPdt_L PDTL ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = @pnLang
	-- 04.06.00 --

	SET @FNResult= 0
END TRY
BEGIN CATCH
    SET @FNResult= -1
	SELECT ERROR_MESSAGE()
END CATCH
GO
IF EXISTS
(SELECT * FROM dbo.sysobjects WHERE id = object_id(N'STP_GETaPdtScan')and OBJECTPROPERTY(id, N'IsProcedure') = 1)
DROP PROCEDURE [dbo].STP_GETaPdtScan
GO
CREATE PROCEDURE [dbo].STP_GETaPdtScan
 @ptPdtValue varchar(20)
,@ptPplCode varchar(20) 
,@FNResult INT OUTPUT AS
/*---------------------------------------------------------------------
Document History
Version		Date			User	Remark
00.01.00	21/04/2020		Em		create  
00.02.00	21/04/2020		Em		แก้ไขปรับปรุง
00.03.00	22/04/2020		Em		แก้ไขปรับปรุง
04.01.00	06/07/2020		Em		ตั้งต้น SKC
04.02.00	14/07/2020		Em		เพิ่ม StkControl
04.03.00    30/09/2022		Arm		เพิ่ม WHERE FTPdtRefID
04.04.00	08/10/2022		Arm		เพิ่ม FTVatCode,FCPdtVatRate
04.05.00	01/11/2022		Arm		เพิ่ม FTPdtRefID
----------------------------------------------------------------------*/
BEGIN TRY
	SELECT DISTINCT PDT.FTPdtCode AS tPdtCode,
	FTBarCode AS tBarcode,
	FTPdtName AS tPdtName,
	PDT.FTPunCode AS tPunCode,
	FTPunName AS tUnitName,
	FCPdtUnitFact AS cUnitFactor,
	ISNULL(GrpPri.FCpdtPrice,ISNULL(PDT.FCPdtPrice,0)) AS cPdtPrice,
	0 nRowCount,
	'' AS tPicPath,
	FTPdtSaleType AS tSaleType,
	FTPdtStaAlwDis AS tStaAlwDis,
	FTPgpChain AS tPgpChain, -- 04.01.00 --
	FTPdtStkControl AS tStkControl,	-- 04.02.00 --
	FTVatCode AS tVatCode, 
	FCPdtVatRate AS cPdtVatRate,
	PDT.FTPdtRefID AS tPdtRefID -- 04.05.00 --
	FROM TPSMPdt PDT
	LEFT JOIN  TPSTPdtPrice GrpPri WITH(NOLOCK) ON PDT.FTPdtCode = GrpPri.FTPdtCode
		AND PDT.FTPunCode = GrpPri.FTPunCode AND (ISNULL(GrpPri.FTPplCode,'') = @ptPplCode)
	--WHERE (PDT.FTPdtCode = @ptPdtValue OR PDT.FTBarCode = @ptPdtValue)  
	WHERE (PDT.FTPdtCode = @ptPdtValue OR PDT.FTBarCode = @ptPdtValue OR PDT.FTPdtRefID = @ptPdtValue)  -- 04.03.00 --
	SET @FNResult= 0
END TRY
BEGIN CATCH
    SET @FNResult= -1
	SELECT ERROR_MESSAGE()
END CATCH
GO

--++++++++++++++++++++++++++++++++++++ END 04/11/2022 V.01.00.00 +++++++++++++++++++++++++++++++++

--++++++++++++++++++++++++++++++++++++ Start 08/12/2022 V.20002.02.00 08122022 +++++++++++++++++++++++++++++++++

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SP_RPTxDiscPmtByBill]') AND type in (N'P', N'PC'))
BEGIN
EXEC dbo.sp_executesql @statement = N'CREATE PROCEDURE [dbo].[SP_RPTxDiscPmtByBill] AS' 
END
GO
ALTER PROCEDURE [dbo].[SP_RPTxDiscPmtByBill] 
--ALTER PROCEDURE [dbo].[SP_RPTxDailySaleByInvByPdt1001002] 
	@pnLngID int , 
	@pnComName Varchar(100),
	@ptRptCode Varchar(100),
	@ptUsrSession Varchar(255),

	@pnFilterType int, --1 BETWEEN 2 IN
	--สาขา
	@ptBchL Varchar(8000), --กรณี Condition IN
	@ptBchF Varchar(5),
	@ptBchT Varchar(5),
	--Merchant
	@ptMerL Varchar(8000), --กรณี Condition IN
	@ptMerF Varchar(10),
	@ptMerT Varchar(10),
	--Shop Code
	@ptShpL Varchar(8000), --กรณี Condition IN
	@ptShpF Varchar(10),
	@ptShpT Varchar(10),
	--เครื่องจุดขาย
	@ptPosL Varchar(8000), --กรณี Condition IN
	@ptPosF Varchar(20),
	@ptPosT Varchar(20),

	----ลูกค้า
	@ptCstF Varchar(20),
	@ptCstT Varchar(20),

	--Channel
	@ptChnF Varchar(5),
	@ptChnT Varchar(5),


	@ptDocDateF Varchar(10),
	@ptDocDateT Varchar(10),

	@FNResult INT OUTPUT 
AS
--------------------------------------
-- Watcharakorn 
-- Create 10/07/2019
-- Temp name  TRPTSalRCTmp
-- รายงาน - ส่วนลดโปรโมชั่นตามเอกสาร
-- @pnLngID ภาษา
-- @ptRptCdoe ชื่อรายงาน
-- @ptUsrSession UsrSession
-- @ptBchF จากรหัสสาขา
-- @ptBchT ถึงรหัสสาขา
-- @ptShpF จากร้านค้า
-- @ptShpT ถึงร้านค้า
-- @ptPdtCodeF จากสินค้า
-- @ptPdtCodeT ถึงสินค้า
-- @ptPdtChanF จากกลุ่มสินค้า
-- @ptPdtChanT ถึงกลุ่มสินค้า
-- @ptPdtTypeF จากประเภทสินค้า
-- @ptPdtTypeT ถึงประเภท

-- @ptDocDateF จากวันที่
-- @ptDocDateT ถึงวันที่
-- @FNResult


--------------------------------------
BEGIN TRY

	DECLARE @nLngID int 
	DECLARE @nComName Varchar(100)
	DECLARE @tRptCode Varchar(100)
	DECLARE @tUsrSession Varchar(255)
	DECLARE @tSql VARCHAR(8000)
	DECLARE @tSqlIns VARCHAR(8000)
	DECLARE @tSql1 VARCHAR(Max)
	DECLARE @tSql2 VARCHAR(8000)
	DECLARE @tSqlDrop VARCHAR(8000)
	DECLARE @tTblName Varchar(255)

	DECLARE @tSqlHD Varchar(8000)
	DECLARE @tSqlRC Varchar(8000)
	DECLARE @tSqlSalHD Varchar(8000)

	--Branch Code
	DECLARE @tBchF Varchar(5)
	DECLARE @tBchT Varchar(5)
	--Merchant
	DECLARE @tMerF Varchar(10)
	DECLARE @tMerT Varchar(10)
	--Shop Code
	DECLARE @tShpF Varchar(10)
	DECLARE @tShpT Varchar(10)
	--Pos Code
	DECLARE @tPosF Varchar(20)
	DECLARE @tPosT Varchar(20)
	--ลูกค้า
	DECLARE @tCstF Varchar(20)
	DECLARE @tCstT Varchar(20)
	--Channel
	DECLARE @tChnF Varchar(10)
	DECLARE @tChnT Varchar(10)

	DECLARE @tDocDateF Varchar(10)
	DECLARE @tDocDateT Varchar(10)


	SET @nLngID = @pnLngID
	SET @nComName = @pnComName
	SET @tUsrSession = @ptUsrSession
	SET @tRptCode = @ptRptCode

	--สาขา
	SET @tBchF = @ptBchF
	SET @tBchT = @ptBchT
	--ร้านค้า
	SET @tShpF = @ptShpF
	SET @tShpT = @ptShpT
	--เครื่องจุดขาย
	SET @tPosF = @ptPosF
	SET @tPosT = @ptPosT
	--กลุ่มธุรกิจ
	SET @tMerF = @ptMerF
	SET @tMerT = @ptMerT
	--ลูกค้า
	SET @tCstF = @ptCstF
	SET @tCstT = @ptCstT
	--Channel
	SET @tChnF  = @ptChnF
	SET @tChnT  = @ptChnT

	SET @tDocDateF = @ptDocDateF
	SET @tDocDateT = @ptDocDateT
	SET @FNResult= 0

	SET @tDocDateF = CONVERT(VARCHAR(10),@tDocDateF,121)
	SET @tDocDateT = CONVERT(VARCHAR(10),@tDocDateT,121)

	IF @nLngID = null
	BEGIN
		SET @nLngID = 1
	END	
	--Set ค่าให้ Paraleter กรณี T เป็นค่าว่างหรือ null


	IF @ptBchL = null
	BEGIN
		SET @ptBchL = ''
	END

	IF @tBchF = null
	BEGIN
		SET @tBchF = ''
	END
	IF @tBchT = null OR @tBchT = ''
	BEGIN
		SET @tBchT = @tBchF
	END

	IF @ptMerL =null
	BEGIN
		SET @ptMerL = ''
	END

	IF @tMerF =null
	BEGIN
		SET @tMerF = ''
	END
	IF @tMerT =null OR @tMerT = ''
	BEGIN
		SET @tMerT = @tMerF
	END 

	IF @ptShpL =null
	BEGIN
		SET @ptShpL = ''
	END

	IF @tShpF =null
	BEGIN
		SET @tShpF = ''
	END
	IF @tShpT =null OR @tShpT = ''
	BEGIN
		SET @tShpT = @tShpF
	END

	IF @tPosF = null
	BEGIN
		SET @tPosF = ''
	END
	IF @tPosT = null OR @tPosT = ''
	BEGIN
		SET @tPosT = @tPosF
	END

	IF @tCstF = null
	BEGIN
		SET @tCstF = ''
	END 
	IF @tCstT = null OR @tCstT =''
	BEGIN
		SET @tCstT = @tCstF
	END 

	-----------------------------------
	--Channel
	IF @tChnF =null
	BEGIN
		SET @tChnF = ''
	END
	IF @tChnT =null OR @tChnT = ''
	BEGIN
		SET @tChnT = @tChnF
	END
	-----------------------------------

	IF @tDocDateF = null
	BEGIN 
		SET @tDocDateF = ''
	END
	IF @tDocDateT = null OR @tDocDateT =''
	BEGIN 
		SET @tDocDateT = @tDocDateF
	END
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	--SET @tSql1 =   ' WHERE 1=1 AND FTXshStaDoc = ''1'''
	--SET @tSqlHD =   ' WHERE 1=1 AND FTXshStaDoc = ''1'''
	--SET @tSqlRC =   ' WHERE 1=1 AND FTXshStaDoc = ''1'''
	SET @tSql1 =   ' '
	SET @tSqlHD =   ' '
	SET @tSqlRC =   ' '
	SET @tSqlSalHD = ' '

	IF @pnFilterType = '1'
	BEGIN
		IF (@tBchF <> '' AND @tBchT <> '')
		BEGIN
			SET @tSqlHD +=' AND HD.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
			SET @tSql1 +=' AND HD.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
			SET @tSqlRC +=' AND HD.FTBchCode BETWEEN ''' + @tBchF + ''' AND ''' + @tBchT + ''''
		END

		IF (@tMerF <> '' AND @tMerT <> '')
		BEGIN
			SET @tSqlHD +=' AND SHP.FTMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
			SET @tSql1 +=' AND SHP.FTMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
			SET @tSqlRC +=' AND SHP.FTMerCode BETWEEN ''' + @tMerF + ''' AND ''' + @tMerT + ''''
		END

		IF (@tShpF <> '' AND @tShpT <> '')
		BEGIN
			SET @tSqlHD +=' AND HD.FTShpCode BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
			SET @tSql1 +=' AND HD.FTShpCode BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
			SET @tSqlRC +=' AND HD.FTShpCode BETWEEN ''' + @tShpF + ''' AND ''' + @tShpT + ''''
		END

		IF (@tPosF <> '' AND @tPosT <> '')
		BEGIN
			SET @tSqlHD += ' AND HD.FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
			SET @tSql1 += ' AND HD.FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
			SET @tSqlRC += ' AND HD.FTPosCode BETWEEN ''' + @tPosF + ''' AND ''' + @tPosT + ''''
		END		
	END

	IF @pnFilterType = '2'
	BEGIN
		IF (@ptBchL <> '' )
		BEGIN
			SET @tSqlHD +=' AND HD.FTBchCode IN (' + @ptBchL + ')'
			SET @tSql1 +=' AND HD.FTBchCode IN (' + @ptBchL + ')'
			SET @tSqlRC +=' AND HD.FTBchCode IN (' + @ptBchL + ')'
		END

		IF (@ptMerL <> '' )
		BEGIN
			SET @tSqlHD +=' AND SHP.FTMerCode IN (' + @ptMerL + ')'
			SET @tSql1 +=' AND SHP.FTMerCode IN (' + @ptMerL + ')'
			SET @tSqlRC +=' AND SHP.FTMerCode IN (' + @ptMerL + ')'
		END

		IF (@ptShpL <> '')
		BEGIN
			SET @tSqlHD +=' AND HD.FTShpCode IN (' + @ptShpL + ')'
			SET @tSql1 +=' AND HD.FTShpCode IN (' + @ptShpL + ')'
			SET @tSqlRC +=' AND HD.FTShpCode IN (' + @ptShpL + ')'
		END

		IF (@ptPosL <> '')
		BEGIN
			SET @tSqlHD += ' AND HD.FTPosCode IN (' + @ptPosL + ')'
			SET @tSql1 += ' AND HD.FTPosCode IN (' + @ptPosL + ')'
			SET @tSqlRC += ' AND HD.FTPosCode IN (' + @ptPosL + ')'
		END		
	END

	IF (@tCstF <> '' AND @tCstT <> '')
	BEGIN
		SET @tSql1 +=' AND FTCstCode BETWEEN ''' + @tCstF + ''' AND ''' + @tCstT + ''''
		SET @tSqlHD +=' AND HD.FTCstCode BETWEEN ''' + @tCstF + ''' AND ''' + @tCstT + ''''
		SET @tSqlRC +=' AND HD.FTCstCode BETWEEN ''' + @tCstF + ''' AND ''' + @tCstT + ''''
	END

	IF (@tChnF <> '' AND @tChnT <> '')
	BEGIN
		SET @tSqlSalHD +=' AND HD.FTChnCode BETWEEN ''' + @tChnF + ''' AND ''' + @tChnT + ''' '
		SET @tSqlSalHD +=' AND ISNULL(CHN_L.FTChnCode,'''') != '''' '
	END

	IF (@tDocDateF <> '' AND @tDocDateT <> '')
	BEGIN
		SET @tSql1 +=' AND CONVERT(VARCHAR(10),FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
		SET @tSqlHD +=' AND CONVERT(VARCHAR(10),FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
		SET @tSqlRC +=' AND CONVERT(VARCHAR(10),FDXshDocDate,121) BETWEEN ''' + @tDocDateF + ''' AND ''' + @tDocDateT + ''''
	END

	DELETE FROM TRPTSalPdtBillPmtTmp WITH (ROWLOCK) WHERE FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--ลบข้อมูล Temp ของเครื่องที่จะบันทึกขอมูลลง Temp

	-- HD Sale
	SET @tSqlIns = ' INSERT INTO TRPTSalPdtBillPmtTmp'
	SET @tSqlIns += ' (FTComName,FTRptCode,FTUsrSession,FNAppType,FNType,FNXshDocType,FDXshDocDate,FTXshDocNo,FTXshRefInt,FTCstCode,FTCstName,FCXshVatable,FCXshVat,FCXshDis,FCXshTotalAfDis,FCXshRnd,FCXshGrand,'	
	SET @tSqlIns += ' FTPdtCode,FTPdtName, FTPunName,FCXsdQty,FCXsdSetPrice, FCXsdAmt,   FCXsdDis,  FCXsdNet,'
    SET @tSqlIns += ' FTRcvName, FTXrcRefNo1, FDXrcRefDate, FTBnkName, FCXrcNet , FTBchCode , FTBchName,'
	--10/11/2020
	SET @tSqlIns += ' FTXshSOKADS,FCXdtDisPmt,FTPmhName,FCXshDisPnt,FTChnCode,FTChnName '
	SET @tSqlIns += ' )'	
	SET @tSqlIns += ' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSqlIns += ' 1 AS FNAppType,1 AS FNType,HD.FNXshDocType,CONVERT(VARCHAR(10),FDXshDocDate,121) AS FDXshDocDate, HD.FTXshDocNo,FTXshRefInt,HD.FTCstCode,HDCst.FTXshCstName,'
	--SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshVatable,0) ELSE ISNULL(FCXshVatable,0)*-1 END AS FCXshVatable,'
	--SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshVat,0) ELSE ISNULL(FCXshVat,0)*-1 END AS FCXshVat,'
	SET @tSqlIns += ' ROUND((CASE WHEN LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVatable),2),1) = ''5'' AND LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVat),2),1) = ''5'' THEN CAST(SUBSTRING(CONVERT(VARCHAR(22),FCXshVatable),1,LEN(CONVERT(VARCHAR(22),CONVERT(VARCHAR(22),FCXshVatable)))-2) AS DECIMAL(18,2))  ELSE FCXshVatable END ),2) AS FCXshVatable,'
	SET @tSqlIns += ' ROUND((CASE WHEN LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVatable),2),1) = ''5'' AND LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVat),2),1) = ''5'' THEN CAST(SUBSTRING(CONVERT(VARCHAR(22),FCXshVat),1,LEN(CONVERT(VARCHAR(22),FCXshVat))-2) AS DECIMAL(18,2))  ELSE FCXshVat END ),2) AS FCXshVat,'	
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL( FCXshDisc, 0 ) *- 1 ELSE ISNULL( FCXshDisc, 0 ) END  AS FCXshDis,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshTotal,0)+(ISNULL(FCXshChg,0)- ISNULL(FCXshDis,0)) ELSE (ISNULL(FCXshTotal,0)+(ISNULL(FCXshChg,0)- ISNULL(FCXshDis,0)))*-1 END AS FCXshTotalAfDis,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshRnd,0) ELSE ISNULL(FCXshRnd,0)*-1 END AS FCXshRnd, '
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshGrand,0) ELSE ISNULL(FCXshGrand,0)*-1 END AS FCXshGrand,'
	SET @tSqlIns += ' '''' AS FTPdtCode,'''' AS FTPdtName,'''' AS FTPunName,0 AS FCXsdQty,0 AS FCXsdSetPrice,0 AS FCXsdAmt, 0 AS FCXsdDis, 0 AS FCXsdNet,'
	SET @tSqlIns += ' '''' AS FTRcvName,'''' AS FTXrcRefNo1,NULL AS FDXrcRefDate,'''' AS FTBnkName,0 AS FCXrcNet , BCHL.FTBchCode , BCHL.FTBchName,'
	--10/11/2020
	SET @tSqlIns += ' ISNULL(LogAPI6.FTLogRefNo,'''') AS FTXshSOKADS,0 AS FCXdtDisPmt,'''' AS FTPmhName,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshDisPnt,0)*-1 ELSE ISNULL(FCXshDisPnt,0) END AS FCXshDisPnt, ' 
	--1. New เลข SO KADS
	SET @tSqlIns += ' CHN_L.FTChnCode, CHN_L.FTChnName ' 
	SET @tSqlIns += ' FROM TPSTSalHD HD WITH (NOLOCK) LEFT JOIN'
	SET @tSqlIns += ' (SELECT  Log1.FNLogID, Log1.FTBchCode,Log1.FTXshDocNo ,Log1.FTLogRefNo'
		SET @tSqlIns += ' FROM TLKTLogAPI6 Log1 WITH (NOLOCK)' 
		SET @tSqlIns += ' INNER JOIN'
			SET @tSqlIns += ' (SELECT  MAX(FNLogID) AS FNLogID, FTBchCode,FTXshDocNo' 
			SET @tSqlIns += ' FROM TLKTLogAPI6 WITH (NOLOCK)'
			--WHERE FTXshDocNo = 'S2000007000290000001'
			SET @tSqlIns += ' GROUP BY FTBchCode,FTXshDocNo'
			SET @tSqlIns += ' ) Log2 ON Log1.FNLogID= Log2.FNLogID AND  Log1.FTBchCode =  Log2.FTBchCode AND Log1.FTXshDocNo = Log2.FTXshDocNo'
	SET @tSqlIns += ' ) LogAPI6 ON HD.FTBchCode = LogAPI6.FTBchCode AND HD.FTXshDocNo = LogAPI6.FTXshDocNo'
	--4. ส่วนลด HD + ส่วนลดแลกแต้ม
    SET @tSqlIns += ' LEFT JOIN'
	SET @tSqlIns += ' (SELECT HDDisc.FTBchCode,HDDisc.FTXshDocNo,'
	 SET @tSqlIns += ' SUM(CASE WHEN FNXddStaDis = 2 AND (FTXddRefCode = '''' OR FTXddRefCode = null)THEN  CASE WHEN FTXddDisChgType IN (''1'',''2'') THEN  FCXddValue ELSE FCXddValue *- 1 END  ELSE 0 END) AS FCXshDisc,'
	 SET @tSqlIns += ' SUM(CASE WHEN FNXddStaDis = 2 AND ISNULL(FTXddRefCode, '''') <> '''' THEN  CASE WHEN FTXddDisChgType IN (''1'',''2'') THEN  FCXddValue ELSE FCXddValue *- 1 END  ELSE 0 END) AS FCXshDisPnt'
	 SET @tSqlIns += ' FROM TPSTSalDTDis HDDisc WITH (NOLOCK) '
	-- SET @tSqlIns += ' LEFT JOIN TPSTSalHD HD  WITH (NOLOCK) ON HD.FTBchCode = HDDisc.FTBchCode AND HD.FTXshDocNo = HDDisc.FTXshDocNo'
--  	 SET @tSqlIns += ' LEFT JOIN (SELECT FTBchCode,FTXshDocNo,FTXrdRefCode FROM TPSTSalRD RD WITH (NOLOCK)) RD ON HDDisc.FTBchCode = RD.FTBchCode AND HDDisc.FTXshDocNo = RD.FTXshDocNo AND HDDisc.FTXhdRefCode = RD.FTXrdRefCode'
	-- WHERE HDDisc.FTXshDocNo = 'S2000005000050000050'
		SET @tSqlIns += ''
 	 SET @tSqlIns += ' GROUP BY HDDisc.FTBchCode,HDDisc.FTXshDocNo'
	SET @tSqlIns += ' ) HDDisc ON HD.FTBchCode = HDDisc.FTBchCode AND HD.FTXshDocNo = HDDisc.FTXshDocNo'

	--SET @tSqlIns += ' LEFT JOIN TCNMCst_L Cst_L ON HD.FTCstCode = Cst_L.FTCstCode  AND Cst_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	SET @tSqlIns += ' LEFT JOIN TPSTSalHDCst HDCst WITH (NOLOCK) ON HD.FTBchCode = HDCst.FTBchCode AND HD.FTXshDocNo = HDCst.FTXshDocNo'
	SET @tSqlIns += ' LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode '
	--SET @tSqlIns += ' LEFT JOIN TCNMChannel CHN WITH(NOLOCK) ON HD.FTChnCode = CHN.FTChnCode  '
	SET @tSqlIns += ' LEFT JOIN TCNMChannel_L CHN_L WITH(NOLOCK) ON HD.FTChnCode = CHN_L.FTChnCode AND CHN_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns += ' WHERE 1=1 AND FTXshStaDoc = ''1'''
	SET @tSqlIns += @tSqlHD
	SET @tSqlIns += @tSqlSalHD

	--HD Vending
	SET @tSqlIns += 'UNION ALL'
    SET @tSqlIns += ' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSqlIns += ' 2 AS FNAppType,1 AS FNType,HD.FNXshDocType,CONVERT(VARCHAR(10),FDXshDocDate,121) AS FDXshDocDate, HD.FTXshDocNo,FTXshRefInt,HD.FTCstCode,HDCst.FTXshCstName,'
	--SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshVatable,0) ELSE ISNULL(FCXshVatable,0)*-1 END AS FCXshVatable,'
	--SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshVat,0) ELSE ISNULL(FCXshVat,0)*-1 END AS FCXshVat,'
	SET @tSqlIns += ' ROUND((CASE WHEN LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVatable),2),1) = ''5'' AND LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVat),2),1) = ''5'' THEN CAST(SUBSTRING(CONVERT(VARCHAR(22),FCXshVatable),1,LEN(CONVERT(VARCHAR(22),CONVERT(VARCHAR(22),FCXshVatable)))-2) AS DECIMAL(18,2))  ELSE FCXshVatable END ),2) AS FCXshVatable,'
	SET @tSqlIns += ' ROUND((CASE WHEN LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVatable),2),1) = ''5'' AND LEFT(RIGHT(CONVERT(VARCHAR(22),FCXshVat),2),1) = ''5'' THEN CAST(SUBSTRING(CONVERT(VARCHAR(22),FCXshVat),1,LEN(CONVERT(VARCHAR(22),FCXshVat))-2) AS DECIMAL(18,2))  ELSE FCXshVat END ),2) AS FCXshVat,'	
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshChg,0)- ISNULL(FCXshDis,0) ELSE (ISNULL(FCXshChg,0)- ISNULL(FCXshDis,0))*-1 END  AS FCXshDis,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshTotal,0)+(ISNULL(FCXshChg,0)- ISNULL(FCXshDis,0)) ELSE (ISNULL(FCXshTotal,0)+(ISNULL(FCXshChg,0)- ISNULL(FCXshDis,0)))*-1 END AS FCXshTotalAfDis,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshRnd,0) ELSE ISNULL(FCXshRnd,0)*-1 END AS FCXshRnd, '
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXshGrand,0) ELSE ISNULL(FCXshGrand,0)*-1 END AS FCXshGrand,'
	SET @tSqlIns += ' '''' AS FTPdtCode,'''' AS FTPdtName,'''' AS FTPunName,0 AS FCXsdQty,0 AS FCXsdSetPrice,0 AS FCXsdAmt, 0 AS FCXsdDis, 0 AS FCXsdNet,'
	SET @tSqlIns += ' '''' AS FTRcvName,'''' AS FTXrcRefNo1,NULL AS FDXrcRefDate,'''' AS FTBnkName,0 AS FCXrcNet ,BCHL.FTBchCode , BCHL.FTBchName,'
	--10/11/2020
	SET @tSqlIns += ' ISNULL(LogAPI6.FTLogRefNo,'''') AS FTXshSOKADS,0 AS FCXdtDisPmt,'''' AS FTPmhName,0 AS FCXshDisPnt, ' 
	SET @tSqlIns += ' NULL AS FTChnCode, NULL AS FTChnName ' 
	SET @tSqlIns += ' FROM TVDTSalHD HD WITH (NOLOCK) LEFT JOIN'
	SET @tSqlIns += ' (SELECT  Log1.FNLogID, Log1.FTBchCode,Log1.FTXshDocNo ,Log1.FTLogRefNo'
		SET @tSqlIns += ' FROM TLKTLogAPI6 Log1 WITH (NOLOCK)' 
		SET @tSqlIns += ' INNER JOIN'
			SET @tSqlIns += ' (SELECT  MAX(FNLogID) AS FNLogID, FTBchCode,FTXshDocNo' 
			SET @tSqlIns += ' FROM TLKTLogAPI6 WITH (NOLOCK)'
			--WHERE FTXshDocNo = 'S2000007000290000001'
			SET @tSqlIns += ' GROUP BY FTBchCode,FTXshDocNo'
			SET @tSqlIns += ' ) Log2 ON Log1.FNLogID= Log2.FNLogID AND  Log1.FTBchCode =  Log2.FTBchCode AND Log1.FTXshDocNo = Log2.FTXshDocNo'
	SET @tSqlIns += ' ) LogAPI6 ON HD.FTBchCode = LogAPI6.FTBchCode AND HD.FTXshDocNo = LogAPI6.FTXshDocNo'
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns +=' INNER JOIN TVDTSalRC RC WITH(NOLOCK) ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
	SET @tSqlIns +=' LEFT JOIN TFNMRcv Rcv WITH(NOLOCK) ON  RC.FTRcvCode = Rcv.FTRcvCode'			
	------------
	--SET @tSqlIns += ' LEFT JOIN TCNMCst_L Cst_L ON HD.FTCstCode = Cst_L.FTCstCode  AND Cst_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TPSTSalHDCst HDCst WITH (NOLOCK) ON HD.FTBchCode = HDCst.FTBchCode AND HD.FTXshDocNo = HDCst.FTXshDocNo'
	SET @tSqlIns += ' LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode '
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns += ' WHERE 1=1 AND FTXshStaDoc = ''1''   AND Rcv.FTFmtCode <> ''004'''
	SET @tSqlIns +=  @tSqlHD
	--SET @tSqlIns += @tSql1
	--SELECT @tSqlIns
	EXECUTE(@tSqlIns)

	UPDATE TRPTSalPdtBillPmtTmp SET  FCXshVat = CASE WHEN FNXshDocType = '1' THEN FCXshVat ELSE FCXshVat *-1 END ,
									 FCXshVatable = CASE WHEN FNXshDocType = '1' THEN FCXshVatable ELSE FCXshVatable *-1 END 
	                                   
	WHERE FNType = 1 AND FTComName =  '' + @nComName + ''  AND FTRptCode = '' + @tRptCode + '' AND FTUsrSession = '' + @tUsrSession + ''--ลบข้อมูล Temp ของเครื่องที่จะบันทึกขอมูลลง Temp


	--SET @tSqlIns += ' UNION ALL'
	----DT SALE
	SET @tSqlIns = ' INSERT INTO TRPTSalPdtBillPmtTmp'
	SET @tSqlIns += ' (FTComName,FTRptCode,FTUsrSession,FNAppType,FNType,FNXshDocType,FDXshDocDate,FTXshDocNo,FTXshRefInt,FTCstCode,FTCstName,FCXshVatable,FCXshVat,FCXshDis,FCXshTotalAfDis,FCXshRnd,FCXshGrand,'	
	SET @tSqlIns += ' FTPdtCode,FTPdtName, FTPunName,FCXsdQty,FCXsdSetPrice, FCXsdAmt,   FCXsdDis,  FCXsdNet,'
    SET @tSqlIns += ' FTRcvName, FTXrcRefNo1, FDXrcRefDate, FTBnkName, FCXrcNet , FTBchCode , FTBchName,FCXdtDisPmt,FTPmhName,FTXsdVatType, FTChnCode, FTChnName)'	
	SET @tSqlIns += ' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSqlIns += ' 1 AS FNAppType,2 AS FNType,HD.FNXshDocType,CONVERT(VARCHAR(10),HD.FDXshDocDate,121) AS FDXshDocDate, HD.FTXshDocNo,'''' AS FTXshRefInt,HD.FTCstCode,'''' AS FTCstName,'
	SET @tSqlIns += ' 0 AS FCXshVatable,0 AS FCXshVat,'
	--SET @tSqlIns += ' ROUND((CASE WHEN LEFT(RIGHT(CONVERT(VARCHAR(22),FCXsdVatable),2),1) = ''5'' AND LEFT(RIGHT(CONVERT(VARCHAR(22),FCXsdVat),2),1) = ''5'' THEN CAST(SUBSTRING(CONVERT(VARCHAR(22),FCXsdVatable),1,LEN(CONVERT(VARCHAR(22),CONVERT(VARCHAR(22),FCXsdVatable)))-2) AS DECIMAL(18,2))  ELSE FCXshVatable END ),2) AS FCXshVatable,'
	--SET @tSqlIns += ' ROUND((CASE WHEN LEFT(RIGHT(CONVERT(VARCHAR(22),FCXsdVatable),2),1) = ''5'' AND LEFT(RIGHT(CONVERT(VARCHAR(22),FCXsdVat),2),1) = ''5'' THEN CAST(SUBSTRING(CONVERT(VARCHAR(22),FCXsdVat),1,LEN(CONVERT(VARCHAR(22),FCXsdVat))-2) AS DECIMAL(18,2))  ELSE FCXshVat END ),2) AS FCXshVat,'
	SET @tSqlIns += ' 0 AS FCXshDis, 0 AS FCXshTotalAfDis,0 AS FCXshRnd,0 AS FCXshGrand,'
	SET @tSqlIns += ' DT.FTPdtCode,Pdt_L.FTPdtName,Pun_L.FTPunName,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXsdQty,0) ELSE ISNULL(FCXsdQty,0)*-1 END AS FCXsdQty,'
	SET @tSqlIns += ' ISNULL(FCXsdSetPrice,0) AS FCXsdSetPrice,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXsdSetPrice,0)*ISNULL(FCXsdQty,0) ELSE (ISNULL(FCXsdSetPrice,0)*ISNULL(FCXsdQty,0))*-1 END AS FCXsdAmt,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  (ISNULL(FCXsdChg,0)-ISNULL(FCXsdDis,0)) ELSE (ISNULL(FCXsdChg,0)-ISNULL(FCXsdDis,0))*-1 END As FCXsdDis,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXsdNet,0)-ISNULL(FCXdtDisPmt,0)  ELSE (ISNULL(FCXsdNet,0)-ISNULL(FCXdtDisPmt,0))*-1 END AS FCXsdNet,'
	SET @tSqlIns += ' '''' AS FTRcvName,'''' AS FTXrcRefNo1,NULL AS FDXrcRefDate,'''' AS FTBnkName,0 AS FCXrcNet ,BCHL.FTBchCode , BCHL.FTBchName,'
	--เพิ่มส่วนลด Promotion
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXdtDisPmt,0)*-1 ELSE ISNULL(FCXdtDisPmt,0) END AS FCXdtDisPmt,FTPmhName,FTXsdVatType,'
	SET @tSqlIns += ' CHN_L.FTChnCode, CHN_L.FTChnName '
	SET @tSqlIns += ' FROM TPSTSalHD HD INNER JOIN TPSTSalDT DT ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo'
	--Promotion PD
	SET @tSqlIns += ' LEFT JOIN (SELECT PD.FTBchCode,PD.FTXshDocNo,PD.FTPmhDocNo,PmtL.FTPmhName,FNXsdSeqNo,FTPdtCode,FTPunCode,FCXpdDisAvg AS FCXdtDisPmt' 
	SET @tSqlIns += ' FROM  TPSTSalPD PD WITH (NOLOCK)' 
		  SET @tSqlIns += ' LEFT JOIN  TCNTPdtPmtHD_L PmtL WITH (NOLOCK) ON  PD.FTPmhDocNo = PmtL.FTPmhDocNo'
		  SET @tSqlIns += ' ) PD ON DT.FTBchCode = PD.FTBchCode AND DT.FTXshDocNo = PD.FTXshDocNo AND DT.FNXsdSeqNo = PD.FNXsdSeqNo'

	SET @tSqlIns += ' LEFT JOIN TCNMPdt Pdt ON DT.FTPdtCode = Pdt.FTPdtCode '
	SET @tSqlIns += ' LEFT JOIN TCNMPdt_L Pdt_L ON DT.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TCNMPdtUnit_L Pun_L ON DT.FTPunCode = Pun_L.FTPunCode AND Pun_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''''
	SET @tSqlIns += ' LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode '
	--SET @tSqlIns += ' LEFT JOIN TCNMChannel CHN WITH(NOLOCK) ON HD.FTChnCode = CHN.FTChnCode  '
	SET @tSqlIns += ' LEFT JOIN TCNMChannel_L CHN_L WITH(NOLOCK) ON HD.FTChnCode = CHN_L.FTChnCode AND CHN_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns += ' WHERE 1=1 AND FTXshStaDoc = ''1'''
	SET @tSqlIns += @tSql1
	SET @tSqlIns += @tSqlSalHD

	--DT Vending
	SET @tSqlIns += 'UNION ALL'
	SET @tSqlIns += ' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSqlIns += ' 2 AS FNAppType,2 AS FNType,HD.FNXshDocType,CONVERT(VARCHAR(10),HD.FDXshDocDate,121) AS FDXshDocDate, HD.FTXshDocNo,'''' AS FTXshRefInt,HD.FTCstCode,'''' AS FTCstName,'
	SET @tSqlIns += ' 0 AS FCXshVatable,0 AS FCXshVat,0 AS FCXshDis, 0 AS FCXshTotalAfDis,0 AS FCXshRnd,0 AS FCXshGrand,'
	SET @tSqlIns += ' DT.FTPdtCode,Pdt_L.FTPdtName,Pun_L.FTPunName,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXsdQty,0) ELSE ISNULL(FCXsdQty,0)*-1 END AS FCXsdQty,'
	SET @tSqlIns += ' ISNULL(FCXsdSetPrice,0) AS FCXsdSetPrice,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXsdSetPrice,0)*ISNULL(FCXsdQty,0) ELSE (ISNULL(FCXsdSetPrice,0)*ISNULL(FCXsdQty,0))*-1 END AS FCXsdAmt,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  (ISNULL(FCXsdChg,0)-ISNULL(FCXsdDis,0)) ELSE (ISNULL(FCXsdChg,0)-ISNULL(FCXsdDis,0))*-1 END As FCXsdDis,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXsdNet,0) ELSE ISNULL(FCXsdNet,0)*-1 END AS FCXsdNet,'
	SET @tSqlIns += ' '''' AS FTRcvName,'''' AS FTXrcRefNo1,NULL AS FDXrcRefDate,'''' AS FTBnkName,0 AS FCXrcNet , BCHL.FTBchCode , BCHL.FTBchName,'
	--2020-11-10 เพิ่มส่วนลดโปรโมชั่น
	SET @tSqlIns += ' 0 AS FCXdtDisPmt,'''' AS FTPmhName,FTXsdVatType,'
	SET @tSqlIns += ' NULL AS FTChnCode, NULL AS FTChnName '
	SET @tSqlIns += ' FROM TVDTSalHD HD INNER JOIN TVDTSalDT DT ON HD.FTBchCode = DT.FTBchCode AND HD.FTXshDocNo = DT.FTXshDocNo'
	--NUI 2020-01-13
	SET @tSqlIns +=' INNER JOIN TVDTSalRC RC WITH(NOLOCK) ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
	SET @tSqlIns +=' LEFT JOIN TFNMRcv Rcv WITH(NOLOCK) ON  RC.FTRcvCode = Rcv.FTRcvCode'			
	------------
	SET @tSqlIns += ' INNER JOIN TCNMPdt Pdt ON DT.FTPdtCode = Pdt.FTPdtCode '
	SET @tSqlIns += ' LEFT JOIN TCNMPdt_L Pdt_L ON DT.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TCNMPdtUnit_L Pun_L ON DT.FTPunCode = Pun_L.FTPunCode AND Pun_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode '
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns += ' WHERE 1=1 AND FTXshStaDoc = ''1''  AND Rcv.FTFmtCode <> ''004'''
	SET @tSqlIns += @tSql1

	--PRINT @tSqlIns
	EXECUTE(@tSqlIns)
	--SET @tSqlIns += ' UNION ALL'
	----RC
	SET @tSqlIns = ' INSERT INTO TRPTSalPdtBillPmtTmp'
	SET @tSqlIns += ' (FTComName,FTRptCode,FTUsrSession,FNAppType,FNType,FNXshDocType,FDXshDocDate,FTXshDocNo,FTXshRefInt,FTCstCode,FTCstName,FCXshVatable,FCXshVat,FCXshDis,FCXshTotalAfDis,FCXshRnd,FCXshGrand,'	
	SET @tSqlIns += ' FTPdtCode,FTPdtName, FTPunName,FCXsdQty,FCXsdSetPrice, FCXsdAmt,   FCXsdDis,  FCXsdNet,'
    SET @tSqlIns += ' FTRcvName, FTXrcRefNo1, FDXrcRefDate, FTBnkName, FCXrcNet, FTBchCode , FTBchName, FTChnCode, FTChnName )'
	SET @tSqlIns += ' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSqlIns += ' 1 AS FNAppType,3 AS FNType,HD.FNXshDocType,CONVERT(VARCHAR(10),HD.FDXshDocDate,121) AS FDXshDocDate, HD.FTXshDocNo,'''' AS FTXshRefInt,HD.FTCstCode,'''' AS FTCstName,'
	SET @tSqlIns += ' 0 AS FCXshVatable,0 AS FCXshVat,0 AS FCXshDis, 0 AS FCXshTotalAfDis,0 AS FCXshRnd,0 AS FCXshGrand,'
	SET @tSqlIns += ' '''' AS FTPdtCode,'''' AS FTPdtName,'''' AS FTPunName,0 AS FCXsdQty,0 AS FCXsdSetPrice,0 AS FCXsdAmt, 0 AS FCXsdDis, 0 AS FCXsdNet,'
	SET @tSqlIns += ' Rcv_L.FTRcvName,ISNULL(FTXrcRefNo1,'''') AS FTXrcRefNo1, CONVERT(VARCHAR(10),FDXrcRefDate,121) AS FDXrcRefDate,ISNULL(Bnk_L.FTBnkName,'''') AS FTBnkName,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXrcNet,0) ELSE ISNULL(FCXrcNet,0)*-1 END AS FCXrcNet , BCHL.FTBchCode , BCHL.FTBchName,'
	SET @tSqlIns += ' CHN_L.FTChnCode, CHN_L.FTChnName ' 
	SET @tSqlIns += ' FROM TPSTSalHD HD INNER JOIN TPSTSalRC RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
	SET @tSqlIns += ' LEFT JOIN TFNMRcv_L Rcv_L ON RC.FTRcvCode = Rcv_L.FTRcvCode AND Rcv_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TFNMBank_L Bnk_L ON RC.FTBnkCode = Bnk_L.FTBnkCode AND Bnk_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode '
	--SET @tSqlIns += ' LEFT JOIN TCNMChannel CHN WITH(NOLOCK) ON HD.FTChnCode = CHN.FTChnCode  '
	SET @tSqlIns += ' LEFT JOIN TCNMChannel_L CHN_L WITH(NOLOCK) ON HD.FTChnCode = CHN_L.FTChnCode AND CHN_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' '
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns += ' WHERE 1=1 AND FTXshStaDoc = ''1'''
	SET @tSqlIns +=   @tSqlRC
	SET @tSqlIns += @tSqlSalHD

	--RC Vanding
	SET @tSqlIns += 'UNION ALL'
	SET @tSqlIns += ' SELECT '''+ @nComName + ''' AS FTComName,'''+ @tRptCode +''' AS FTRptCode, '''+ @tUsrSession +''' AS FTUsrSession,'
	SET @tSqlIns += ' 2 AS FNAppType,3 AS FNType,HD.FNXshDocType,CONVERT(VARCHAR(10),HD.FDXshDocDate,121) AS FDXshDocDate, HD.FTXshDocNo,'''' AS FTXshRefInt,HD.FTCstCode,'''' AS FTCstName,'
	SET @tSqlIns += ' 0 AS FCXshVatable,0 AS FCXshVat,0 AS FCXshDis, 0 AS FCXshTotalAfDis,0 AS FCXshRnd,0 AS FCXshGrand,'
	SET @tSqlIns += ' '''' AS FTPdtCode,'''' AS FTPdtName,'''' AS FTPunName,0 AS FCXsdQty,0 AS FCXsdSetPrice,0 AS FCXsdAmt, 0 AS FCXsdDis, 0 AS FCXsdNet,'
	SET @tSqlIns += ' Rcv_L.FTRcvName,ISNULL(FTXrcRefNo1,'''') AS FTXrcRefNo1, CONVERT(VARCHAR(10),FDXrcRefDate,121) AS FDXrcRefDate,ISNULL(Bnk_L.FTBnkName,'''') AS FTBnkName,'
	SET @tSqlIns += ' CASE WHEN HD.FNXshDocType = ''1'' THEN  ISNULL(FCXrcNet,0) ELSE ISNULL(FCXrcNet,0)*-1 END AS FCXrcNet , BCHL.FTBchCode , BCHL.FTBchName, '
	SET @tSqlIns += ' NULL AS FTChnCode, NULL AS FTChnName '
	SET @tSqlIns += ' FROM TVDTSalHD HD INNER JOIN TVDTSalRC RC ON HD.FTBchCode = RC.FTBchCode AND HD.FTXshDocNo = RC.FTXshDocNo'
	SET @tSqlIns += ' LEFT JOIN TFNMRcv Rcv WITH(NOLOCK) ON  RC.FTRcvCode = Rcv.FTRcvCode'		
	SET @tSqlIns += ' LEFT JOIN TFNMRcv_L Rcv_L ON RC.FTRcvCode = Rcv_L.FTRcvCode AND Rcv_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TFNMBank_L Bnk_L ON RC.FTBnkCode = Bnk_L.FTBnkCode AND Bnk_L.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + '''' 
	SET @tSqlIns += ' LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON HD.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = '''  + CAST(@nLngID  AS VARCHAR(10)) + ''' ' 
	SET @tSqlIns += ' LEFT JOIN TCNMShop SHP WITH (NOLOCK) ON HD.FTShpCode = SHP.FTShpCode AND HD.FTBchCode = SHP.FTBchCode '
	--NUI 13-01-2020 edit for cut pay cash coupon from rc
	SET @tSqlIns += ' WHERE 1=1 AND FTXshStaDoc = ''1'' AND Rcv.FTFmtCode <> ''004''' 
	SET @tSqlIns +=  @tSqlRC
	--PRINT @tSqlIns
	EXECUTE(@tSqlIns)

	--RETURN SELECT * FROM TRPTSalPdtBillPmtTmp WHERE FTComName = ''+ @nComName + '' AND FTRptCode = ''+ @tRptCode +'' AND FTUsrSession = '' + @tUsrSession + '' ORDER BY FTXshDocNo,FDXshDocDate--,FNType--,FNAppType,FNType--,FDXshDocDate,FTXshDocNo
	
END TRY

BEGIN CATCH 
	SET @FNResult= -1
	--PRINT @tSqlIns
END CATCH
GO

--++++++++++++++++++++++++++++++++++++ END 08/12/2022 V.20002.02.00 08122022 +++++++++++++++++++++++++++++++++
