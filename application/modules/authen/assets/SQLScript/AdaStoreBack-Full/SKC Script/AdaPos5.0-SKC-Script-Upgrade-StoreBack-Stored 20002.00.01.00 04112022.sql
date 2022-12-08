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