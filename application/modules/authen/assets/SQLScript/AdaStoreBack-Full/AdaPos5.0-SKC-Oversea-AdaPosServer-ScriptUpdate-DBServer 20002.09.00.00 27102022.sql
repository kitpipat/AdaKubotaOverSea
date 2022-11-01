--------Script Server From Arm  Update 21/09/2022------------
IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncData WHERE FNSynSeqNo = 146) BEGIN
	INSERT [dbo].[TSysSyncData] ([FNSynSeqNo], [FTSynGroup], [FTSynTable], [FTSynTable_L], [FTSynType], [FDSynLast], [FNSynSchedule], [FTSynStaUse], [FTSynUriDwn], [FTSynUriUld]) 
	VALUES (146, N'CENTER', N'TCNMCountry', N'API2PSMaster', N'1', CAST(N'2022-08-11T00:00:00.000' AS DateTime), 0, N'1', N'/Country/Download?pdDate = {pdDate}', N'')
END
GO

IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncData WHERE FNSynSeqNo = 147) BEGIN
	INSERT [dbo].[TSysSyncData] ([FNSynSeqNo], [FTSynGroup], [FTSynTable], [FTSynTable_L], [FTSynType], [FDSynLast], [FNSynSchedule], [FTSynStaUse], [FTSynUriDwn], [FTSynUriUld]) 
	VALUES (147, N'SYSTEM', N'TCNSJobTask', N'API2PSMaster', N'1', CAST(N'2022-08-11T00:00:00.000' AS DateTime), 0, N'1', N'/JobTask/Download?ptAgnCode={ptAgnCode}', N'')
END
GO

IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncData_L WHERE FNSynSeqNo = 146 AND FNLngID = 1) BEGIN
	INSERT [dbo].[TSysSyncData_L] ([FNSynSeqNo], [FNLngID], [FTSynName], [FTSynRmk]) VALUES (146, 1, N'ข้อมูลประเทศ', N'')
END
GO
IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncData_L WHERE FNSynSeqNo = 146 AND FNLngID = 2) BEGIN
	INSERT [dbo].[TSysSyncData_L] ([FNSynSeqNo], [FNLngID], [FTSynName], [FTSynRmk]) VALUES (146, 2, N'Country', N'')
END
GO
IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncData_L WHERE FNSynSeqNo = 147 AND FNLngID = 1) BEGIN
	INSERT [dbo].[TSysSyncData_L] ([FNSynSeqNo], [FNLngID], [FTSynName], [FTSynRmk]) VALUES (147, 1, N'ข้อมูลตารางงาน', N'')
END
GO
IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncData_L WHERE FNSynSeqNo = 147 AND FNLngID = 2) BEGIN
	INSERT [dbo].[TSysSyncData_L] ([FNSynSeqNo], [FNLngID], [FTSynName], [FTSynRmk]) VALUES (147, 2, N'Job Task', N'')
END
GO

IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncModule WHERE FTAppCode = 'PS' AND FNSynSeqNo = 146) BEGIN
	INSERT [dbo].[TSysSyncModule] ([FTAppCode], [FNSynSeqNo]) VALUES (N'PS', 146)
END
GO

IF NOT EXISTS(SELECT FNSynSeqNo FROM TSysSyncModule WHERE FTAppCode = 'PS' AND FNSynSeqNo = 147) BEGIN
	INSERT [dbo].[TSysSyncModule] ([FTAppCode], [FNSynSeqNo]) VALUES (N'PS', 147)
END
GO

--เพิ่ม Parameter Agrncy Code ใน URL
UPDATE TSysSyncData WITH(ROWLOCK) SET FTSynUriDwn = '/PAY/Rate/Download?pdDate={pdDate}&ptAgnCode={ptAgnCode}' WHERE FNSynSeqNo = 22

------------------------------------START 00.02.00 (21/09/2022)--------------------------------------------------------------------

IF NOT EXISTS(SELECT TOP 1 FTSysCode FROM TSysConfig WHERE FTSysCode = 'tCN_AgnKeyAPI') 
	BEGIN
		INSERT [dbo].[TSysConfig] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FTGmnCode], [FTSysStaAlwEdit], [FTSysStaDataType], [FNSysMaxLength], [FTSysStaDefValue], [FTSysStaDefRef], [FTSysStaUsrValue], [FTSysStaUsrRef], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy]) 
		VALUES (N'tCN_AgnKeyAPI', N'ALL', N'POS', N'1', N'MSAL', N'0', N'0', N'0', N'', N'', N'12345678-1111-1111-1111-123456789410', N'X-Api-Key', CAST(N'2018-09-17T00:00:00.000' AS DateTime), N'Kamonchanok', CAST(N'2018-09-17T00:00:00.000' AS DateTime), N'Kamonchanok')
	END
	GO

IF NOT EXISTS(SELECT TOP 1 FTSysCode FROM TSysConfig_L WHERE FTSysCode = 'tCN_AgnKeyAPI' AND FTSysSeq = 1 AND FNLngID = 1) 
	BEGIN
		INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) 
		VALUES (N'tCN_AgnKeyAPI', N'CN', N'POS', N'1', 1, N'X-API-Key หน่วยงาน', N'', N'')
	END
	GO
IF NOT EXISTS(SELECT TOP 1 FTSysCode FROM TSysConfig_L WHERE FTSysCode = 'tCN_AgnKeyAPI' AND FTSysSeq = 1 AND FNLngID = 2) 
	BEGIN
		INSERT [dbo].[TSysConfig_L] ([FTSysCode], [FTSysApp], [FTSysKey], [FTSysSeq], [FNLngID], [FTSysName], [FTSysDesc], [FTSysRmk]) 
		VALUES (N'tCN_AgnKeyAPI', N'CN', N'POS', N'1', 2, N'X-API-Key Agency', N'', N'')
	END
	GO
-------------------------------------------------- END 00.02.00 (21/09/2022)---------------------------------------------------------

-- ค่า Config จำนวนหลักทศนิยม สำหรับบันทึกอัตราแลกเปลี่ยนเงินตรา
IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig WITH(NOLOCK)
          WHERE FTSysCode = 'ADecPntSavRte' 
		  AND FTSysApp = 'CN' 
		  AND FTSysKey = 'Company' 
		  AND FTSysSeq = '1')
    BEGIN
		INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
		VALUES ('ADecPntSavRte','CN','Company','1','ALL','1','1','4','10','','6','','2022-09-12 02:40:39.000','00001','2020-08-13 00:00:00.000','')
    END

-- ค่า Config จำนวนหลักทศนิยม สำหรับแสดงอัตราแลกเปลี่ยนเงินตรา
IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig WITH(NOLOCK)
          WHERE FTSysCode = 'ADecPntShwRte' 
		  AND FTSysApp = 'CN' 
		  AND FTSysKey = 'DecimalPoint' 
		  AND FTSysSeq = '1')
    BEGIN
		INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
		VALUES ('ADecPntShwRte','CN','DecimalPoint','1','ALL','1','1','4','10','','6','','2022-09-12 02:40:39.000','00001','2020-08-13 00:00:00.000','')
    END



-- ค่า Config จำนวนหลักทศนิยม สำหรับบันทึกอัตราแลกเปลี่ยนเงินตรา (L)
IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig_L WITH(NOLOCK)
			  WHERE FTSysCode = 'ADecPntSavRte' 
			  AND FTSysApp = 'CN' 
			  AND FTSysKey = 'Company' 
			  AND FTSysSeq = '1'
			  AND FNLngID = 1)
    BEGIN
			INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
			VALUES ('ADecPntSavRte','CN','Company','1','1','จำนวนหลักทศนิยม สำหรับบันทึกอัตราแลกเปลี่ยนเงินตรา','กำหนดได้ไม่เกิน 10 หลัก','')
    END

IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig_L WITH(NOLOCK)
			  WHERE FTSysCode = 'ADecPntSavRte' 
			  AND FTSysApp = 'CN' 
			  AND FTSysKey = 'Company' 
			  AND FTSysSeq = '1'
			  AND FNLngID = 2)
    BEGIN
			INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
			VALUES ('ADecPntSavRte','CN','Company','1','2','The number of decimal for save rate.','The maximum config is 10 digit.','')
    END


-- ค่า Config จำนวนหลักทศนิยม สำหรับการแสดงผลอัตรแลกเปลี่ยนเงินตรา (L)
IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig_L WITH(NOLOCK)
          WHERE FTSysCode = 'ADecPntShwRte' 
		  AND FTSysApp = 'CN' 
		  AND FTSysKey = 'DecimalPoint' 
		  AND FTSysSeq = '1'
		  AND FNLngID = 1)
    BEGIN
			INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
			VALUES ('ADecPntShwRte','CN','DecimalPoint','1','1','จำนวนหลักทศนิยม สำหรับการแสดงผลอัตรแลกเปลี่ยนเงินตรา','กำหนดได้ไม่เกิน 10 หลัก','')
    END

IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig_L WITH(NOLOCK)
          WHERE FTSysCode = 'ADecPntShwRte' 
		  AND FTSysApp = 'CN' 
		  AND FTSysKey = 'DecimalPoint' 
		  AND FTSysSeq = '1'
		  AND FNLngID = 2)
    BEGIN
			INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
			VALUES ('ADecPntShwRte','CN','DecimalPoint','1','2','Number of decimal for show rate.','The maximum config is 10 digit.','')
    END




-- Version 01.00.00 [13/09/2022] [พี่รันต์]
-- ปรับโครงสร้างตาราง RC , Rate จาก numeric(18, 10) เป็น numeric(38, 10)

-- TPSTSalRC ตารางการขาย/การชำระเงิน  
IF EXISTS 
  ( SELECT object_id FROM sys.tables
    WHERE name = 'TPSTSalRC'
    AND SCHEMA_NAME(schema_id) = 'dbo'
  )
    
			-- อัตราแลกเปลี่ยน 
			IF COL_LENGTH('TPSTSalRC','FCXrcRteFac') IS NOT NULL
				ALTER TABLE TPSTSalRC 
				ALTER COLUMN FCXrcRteFac numeric(38, 10);
			 ELSE
				ALTER TABLE TPSTSalRC 
				ADD  FCXrcRteFac numeric(38, 10) NULL;
				IF NOT EXISTS ( SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
														FROM SYS.COLUMNS 
														WHERE [name] = 'FCXrcRteFac' 
														AND [object_id] = OBJECT_ID('TPSTSalRC')
													)
								)
					EXEC sp_addextendedproperty 
						@name = N'MS_Description', @value = 'อัตราแลกเปลี่ยน',
						@level0type = N'Schema',   @level0name = 'dbo',
						@level1type = N'Table',    @level1name = 'TPSTSalRC',
						@level2type = N'Column',   @level2name = 'FCXrcRteFac';
					GO

			 -- ยอดคงค้าง(รวมยอดมัดจำ)
			 IF COL_LENGTH('TPSTSalRC','FCXrcFrmLeftAmt') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcFrmLeftAmt numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcFrmLeftAmt numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcFrmLeftAmt' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
					 EXEC sp_addextendedproperty 
							@name = N'MS_Description', @value = 'ยอดคงค้าง เช่น 480+100 (รวมยอดมัดจำ)',
							@level0type = N'Schema',   @level0name = 'dbo',
							@level1type = N'Table',    @level1name = 'TPSTSalRC',
							@level2type = N'Column',   @level2name = 'FCXrcFrmLeftAmt';
					 GO

			 -- ยอดแบงค์ที่ลูกค้าชำระ
			 IF COL_LENGTH('TPSTSalRC','FCXrcUsrPayAmt') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcUsrPayAmt numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcUsrPayAmt numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcUsrPayAmt' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
					 EXEC sp_addextendedproperty 
							@name = N'MS_Description', @value = 'ยอดแบงค์ที่ลูกค้าชำระ  เช่น 1000',
							@level0type = N'Schema',   @level0name = 'dbo',
							@level1type = N'Table',    @level1name = 'TPSTSalRC',
							@level2type = N'Column',   @level2name = 'FCXrcUsrPayAmt';
					 GO

			 -- หักยอดมัดจำสินค้า เช่น 100
			 IF COL_LENGTH('TPSTSalRC','FCXrcDep') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcDep  numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcDep  numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcDep' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
					 EXEC sp_addextendedproperty 
							@name = N'MS_Description', @value = 'หักยอดมัดจำสินค้า เช่น 100',
							@level0type = N'Schema',   @level0name = 'dbo',
							@level1type = N'Table',    @level1name = 'TPSTSalRC',
							@level2type = N'Column',   @level2name = 'FCXrcDep';
					 GO

			 -- ยอดชำระจริง  เช่น 480   (ไม่รวมยอดมัดจำ)
			 IF COL_LENGTH('TPSTSalRC','FCXrcNet ') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcNet  numeric(38, 10) NULL;
			 ELSE
			 ALTER TABLE TPSTSalRC 
			 ADD  FCXrcNet  numeric(38, 10) NULL;
			 IF NOT EXISTS (SELECT NULL 
							FROM SYS.EXTENDED_PROPERTIES 
							WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
							AND   [name] = N'MS_Description' 
							AND   [minor_id] = ( SELECT [column_id] 
												 FROM SYS.COLUMNS 
												 WHERE [name] = 'FCXrcNet' 
												 AND [object_id] = OBJECT_ID('TPSTSalRC')
											   )
							)
			 EXEC sp_addextendedproperty 
					@name = N'MS_Description', @value = 'ยอดชำระจริง  เช่น 480   (ไม่รวมยอดมัดจำ)',
					@level0type = N'Schema',   @level0name = 'dbo',
					@level1type = N'Table',    @level1name = 'TPSTSalRC',
					@level2type = N'Column',   @level2name = 'FCXrcNet';
			 GO

			 -- เงินทอน เช่น 420
			 IF COL_LENGTH('TPSTSalRC','FCXrcChg ') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcChg  numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcChg  numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcChg' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
					 EXEC sp_addextendedproperty 
							@name = N'MS_Description', @value = 'เงินทอน เช่น 420',
							@level0type = N'Schema',   @level0name = 'dbo',
							@level1type = N'Table',    @level1name = 'TPSTSalRC',
							@level2type = N'Column',   @level2name = 'FCXrcChg';
					 GO

			 -- ยอดเงินทอนตาม Rate เงินทอน
			 IF COL_LENGTH('TPSTSalRC','FCXrcRteChgAmt') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcRteChgAmt  numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcRteChgAmt  numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcRteChgAmt' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
					 EXEC sp_addextendedproperty 
							@name = N'MS_Description', @value = 'ยอดเงินทอนตาม Rate เงินทอน',
							@level0type = N'Schema',   @level0name = 'dbo',
							@level1type = N'Table',    @level1name = 'TPSTSalRC',
							@level2type = N'Column',   @level2name = 'FCXrcRteChgAmt';
					 GO

			  -- ยอดปัดเศษเงินทอน
			 IF COL_LENGTH('TPSTSalRC','FCXrcChgRnd') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcChgRnd  numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcChgRnd  numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcChgRnd' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
					 EXEC sp_addextendedproperty 
							@name = N'MS_Description', @value = 'ยอดปัดเศษเงินทอน',
							@level0type = N'Schema',   @level0name = 'dbo',
							@level1type = N'Table',    @level1name = 'TPSTSalRC',
							@level2type = N'Column',   @level2name = 'FCXrcChgRnd';
					 GO


			 -- อัตราแลกเปลี่ยนเงินทอน
			 IF COL_LENGTH('TPSTSalRC','FCXrcRteChgFac') IS NOT NULL
				 ALTER TABLE TPSTSalRC 
				 ALTER COLUMN FCXrcRteChgFac  numeric(38, 10) NULL;
			 ELSE
				 ALTER TABLE TPSTSalRC 
				 ADD  FCXrcRteChgFac  numeric(38, 10) NULL;
				 IF NOT EXISTS (SELECT NULL 
								FROM SYS.EXTENDED_PROPERTIES 
								WHERE [major_id] = OBJECT_ID('TPSTSalRC') 
								AND   [name] = N'MS_Description' 
								AND   [minor_id] = ( SELECT [column_id] 
													 FROM SYS.COLUMNS 
													 WHERE [name] = 'FCXrcRteChgFac' 
													 AND [object_id] = OBJECT_ID('TPSTSalRC')
												   )
								)
				 EXEC sp_addextendedproperty 
						@name = N'MS_Description', @value = 'อัตราแลกเปลี่ยนเงินทอน',
						@level0type = N'Schema',   @level0name = 'dbo',
						@level1type = N'Table',    @level1name = 'TPSTSalRC',
						@level2type = N'Column',   @level2name = 'FCXrcRteChgFac';
				 GO


			-- สกุลเงินที่ทอน 
			IF COL_LENGTH('TPSTSalRC','FTXrcRteChg') IS NULL
			   BEGIN
				   ALTER TABLE TPSTSalRC 
				   ADD [FTXrcRteChg] [varchar](5) NULL;
			   END



----------------------------------------------------------------------------------------------------

-- ตารางสกุลเงิน
IF EXISTS 
  ( SELECT object_id FROM sys.tables
    WHERE name = 'TFNMRate'
    AND SCHEMA_NAME(schema_id) = 'dbo'
  )

	-- อัตราแรกเปลี่ยน
	IF COL_LENGTH('TFNMRate','FCRteRate') IS NOT NULL
	 ALTER TABLE TFNMRate 
	 ALTER COLUMN FCRteRate  numeric(38, 10) NULL;
	ELSE
	 ALTER TABLE TFNMRate 
	 ADD  FCRteRate  numeric(38, 10) NULL;
	 IF NOT EXISTS (SELECT NULL 
					FROM SYS.EXTENDED_PROPERTIES 
					WHERE [major_id] = OBJECT_ID('TFNMRate') 
					AND   [name] = N'MS_Description' 
					AND   [minor_id] = ( SELECT [column_id] 
										 FROM SYS.COLUMNS 
										 WHERE [name] = 'FCRteRate' 
										 AND [object_id] = OBJECT_ID('TFNMRate')
									   )
					)
		 EXEC sp_addextendedproperty 
				@name = N'MS_Description', @value = 'อัตราแรกเปลี่ยน',
				@level0type = N'Schema',   @level0name = 'dbo',
				@level1type = N'Table',    @level1name = 'TFNMRate',
				@level2type = N'Column',   @level2name = 'FCRteRate';
		 GO

	-- อัตราแรกเปลี่ยนล่าสุด
	IF COL_LENGTH('TFNMRate','FCRteLastRate') IS NOT NULL
	 ALTER TABLE TFNMRate 
	 ALTER COLUMN FCRteLastRate  numeric(38, 10) NULL;
	ELSE
	 ALTER TABLE TFNMRate 
	 ADD  FCRteLastRate  numeric(38, 10) NULL;
	 IF NOT EXISTS (SELECT NULL 
					FROM SYS.EXTENDED_PROPERTIES 
					WHERE [major_id] = OBJECT_ID('TFNMRate') 
					AND   [name] = N'MS_Description' 
					AND   [minor_id] = ( SELECT [column_id] 
										 FROM SYS.COLUMNS 
										 WHERE [name] = 'FCRteLastRate' 
										 AND [object_id] = OBJECT_ID('TFNMRate')
									   )
					)
		 EXEC sp_addextendedproperty 
				@name = N'MS_Description', @value = 'อัตราแรกเปลี่ยนล่าสุด',
				@level0type = N'Schema',   @level0name = 'dbo',
				@level1type = N'Table',    @level1name = 'TFNMRate',
				@level2type = N'Column',   @level2name = 'FCRteLastRate';
		 GO

	-- มูลค่าปัดเศษ
	IF COL_LENGTH('TFNMRate','FCRteFraction') IS NOT NULL
	 ALTER TABLE TFNMRate 
	 ALTER COLUMN FCRteFraction  numeric(38, 10) NULL;
	ELSE
	 ALTER TABLE TFNMRate 
	 ADD  FCRteFraction  numeric(38, 10) NULL;
	 IF NOT EXISTS (SELECT NULL 
					FROM SYS.EXTENDED_PROPERTIES 
					WHERE [major_id] = OBJECT_ID('TFNMRate') 
					AND   [name] = N'MS_Description' 
					AND   [minor_id] = ( SELECT [column_id] 
										 FROM SYS.COLUMNS 
										 WHERE [name] = 'FCRteFraction' 
										 AND [object_id] = OBJECT_ID('TFNMRate')
									   )
					)
		 EXEC sp_addextendedproperty 
				@name = N'MS_Description', @value = 'มูลค่าปัดเศษ',
				@level0type = N'Schema',   @level0name = 'dbo',
				@level1type = N'Table',    @level1name = 'TFNMRate',
				@level2type = N'Column',   @level2name = 'FCRteFraction';
		 GO

	-- จำนวนเงินทอนสูงสุดตาม Rate
	IF COL_LENGTH('TFNMRate','FCRteMaxUnit') IS NOT NULL
		 ALTER TABLE TFNMRate 
		 ALTER COLUMN FCRteMaxUnit  numeric(38, 10) NULL;
	ELSE
		 ALTER TABLE TFNMRate 
		 ADD  FCRteMaxUnit  numeric(38, 10) NULL;
		 IF NOT EXISTS (SELECT NULL 
						FROM SYS.EXTENDED_PROPERTIES 
						WHERE [major_id] = OBJECT_ID('TFNMRate') 
						AND   [name] = N'MS_Description' 
						AND   [minor_id] = ( SELECT [column_id] 
											 FROM SYS.COLUMNS 
											 WHERE [name] = 'FCRteMaxUnit' 
											 AND [object_id] = OBJECT_ID('TFNMRate')
										   )
						)
				 EXEC sp_addextendedproperty 
						@name = N'MS_Description', @value = 'จำนวนเงินทอนสูงสุดตาม Rate',
						@level0type = N'Schema',   @level0name = 'dbo',
						@level1type = N'Table',    @level1name = 'TFNMRate',
						@level2type = N'Column',   @level2name = 'FCRteMaxUnit';
				 GO

    -- สถานะ อนุญาตทอน
	IF COL_LENGTH('TFNMRate','FTRteStaAlwChange') IS NULL
	   BEGIN
		   ALTER TABLE TFNMRate 
		   ADD FTRteStaAlwChange  [varchar](1) NULL;
	   END

	-- วันที่ดึงข้อมูลอัตราแลกเปลี่ยนล่าสุดมาจาก AdaServer
	IF COL_LENGTH('TFNMRate','FDRteLastUpdOn') IS NULL
	   BEGIN
		   ALTER TABLE TFNMRate 
		   ADD FDRteLastUpdOn [datetime] NULL;
	   END

	-- รูปแบบการปัดเศษเงินทอน
	IF COL_LENGTH('TFNMRate','FTRteTypeChg') IS NULL
	   BEGIN
		   ALTER TABLE TFNMRate 
		   ADD FTRteTypeChg [varchar](1) NULL;
	   END

	-- รหัสสกุลเงินสากล
	IF COL_LENGTH('TFNMRate','FTRteIsoCode') IS  NULL
		BEGIN
			ALTER TABLE TFNMRate 
			ADD  FTRteIsoCode [varchar](5) NULL;
		END

	-- ตัวแทนจำหน่าย
	IF COL_LENGTH('TFNMRate','FTAgnCode') IS  NULL
		BEGIN
			ALTER TABLE TFNMRate 
			ADD  FTAgnCode [varchar](10)  NOT NULL
			CONSTRAINT FTAgnCode_D DEFAULT ''
			WITH VALUES
		END

	-- Drop Primary Key
	DECLARE @table NVARCHAR(512), @sql NVARCHAR(MAX);
	SELECT @table = N'dbo.TFNMRate';
	SELECT @sql = 'ALTER TABLE ' + @table 
		+ ' DROP CONSTRAINT ' + name + ';'
		FROM sys.key_constraints
		WHERE [type] = 'PK'
		AND [parent_object_id] = OBJECT_ID(@table);

	EXEC sp_executeSQL @sql;

	-- Create Primary Key
	ALTER TABLE TFNMRate
	ADD  CONSTRAINT [PK_TFNMRate_1] PRIMARY KEY CLUSTERED 
	(
		[FTAgnCode] ASC,
	    [FTRteCode] ASC
	)

	 
	
----------------------------------------------------------------------------------------------------

-- Version 02.00.00 [21/09/2022] [พี่รันต์]

-- ตารางใหม่ เก็บข้อมูลอัตราแลกเปลี่ยนสกุลเงินสากล (Iso)
IF EXISTS 
  ( SELECT object_id FROM sys.tables
    WHERE name = 'TCNSRate_L'
    AND SCHEMA_NAME(schema_id) = 'dbo'
  )

	BEGIN
		 TRUNCATE TABLE TCNSRate_L
	END
    
ELSE
	BEGIN

		CREATE TABLE [dbo].[TCNSRate_L](
				[FTRteIsoCode] [varchar](5) NOT NULL,
				[FNLngID] [int] NOT NULL,
				[FTFmtCode] [varchar](5) NULL,
				[FTRteIsoName] [varchar](200) NULL,
				[FTRteIsoRmk] [varchar](200) NULL,
				[FTRteUnitName] [varchar](50) NULL,
				[FTRteSubUnitName] [varchar](50) NULL,
				CONSTRAINT [PK_TCNSRate_L] PRIMARY KEY CLUSTERED 
			(
				[FTRteIsoCode] ASC,
				[FNLngID] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
			) ON [PRIMARY]

	END			
	

-- เพิ่มข้อมูลรหัสสกุลเงินสากล
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AED', 2, NULL, N'United Arab Emirates dirham', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AFN', 2, NULL, N'Afghan afghani', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ALL', 2, NULL, N'Albanian lek', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AMD', 2, NULL, N'Armenian dram', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ANG', 2, NULL, N'Netherlands Antillean guilder', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AOA', 2, NULL, N'Angolan kwanza', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ARS', 2, NULL, N'Argentine peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AUD', 2, NULL, N'Australian dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AWG', 2, NULL, N'Aruban florin', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'AZN', 2, NULL, N'Azerbaijani manat', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BAM', 2, NULL, N'Bosnia and Herzegovina convertible mark', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BBD', 2, NULL, N'Barbados dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BDT', 2, NULL, N'Bangladeshi taka', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BGN', 2, NULL, N'Bulgarian lev', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BHD', 2, NULL, N'Bahraini dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BIF', 2, NULL, N'Burundian franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BMD', 2, NULL, N'Bermudian dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BND', 2, NULL, N'Brunei dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BOB', 2, NULL, N'Boliviano', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BOV', 2, NULL, N'Bolivian Mvdol (funds code)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BRL', 2, NULL, N'Brazilian real', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BSD', 2, NULL, N'Bahamian dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BTN', 2, NULL, N'Bhutanese ngultrum', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BWP', 2, NULL, N'Botswana pula', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BYN', 2, NULL, N'Belarusian ruble', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'BZD', 2, NULL, N'Belize dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CAD', 2, NULL, N'Canadian dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CDF', 2, NULL, N'Congolese franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CHE', 2, NULL, N'WIR euro (complementary currency)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CHF', 2, NULL, N'Swiss franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CHW', 2, NULL, N'WIR franc (complementary currency)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CLF', 2, NULL, N'Unidad de Fomento (funds code)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CLP', 2, NULL, N'Chilean peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CNY', 2, NULL, N'Renminbi[14]', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'COP', 2, NULL, N'Colombian peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'COU', 2, NULL, N'Unidad de Valor Real (UVR) (funds code)[9]', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CRC', 2, NULL, N'Costa Rican colon', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CUC', 2, NULL, N'Cuban convertible peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CUP', 2, NULL, N'Cuban peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CVE', 2, NULL, N'Cape Verdean escudo', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'CZK', 2, NULL, N'Czech koruna', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'DJF', 2, NULL, N'Djiboutian franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'DKK', 2, NULL, N'Danish krone', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'DOP', 2, NULL, N'Dominican peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'DZD', 2, NULL, N'Algerian dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'EGP', 2, NULL, N'Egyptian pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ERN', 2, NULL, N'Eritrean nakfa', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ETB', 2, NULL, N'Ethiopian birr', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'EUR', 2, NULL, N'Euro', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'FJD', 2, NULL, N'Fiji dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'FKP', 2, NULL, N'Falkland Islands pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GBP', 2, NULL, N'Pound sterling', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GEL', 2, NULL, N'Georgian lari', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GHS', 2, NULL, N'Ghanaian cedi', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GIP', 2, NULL, N'Gibraltar pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GMD', 2, NULL, N'Gambian dalasi', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GNF', 2, NULL, N'Guinean franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GTQ', 2, NULL, N'Guatemalan quetzal', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'GYD', 2, NULL, N'Guyanese dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'HKD', 2, NULL, N'Hong Kong dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'HNL', 2, NULL, N'Honduran lempira', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'HRK', 2, NULL, N'Croatian kuna', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'HTG', 2, NULL, N'Haitian gourde', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'HUF', 2, NULL, N'Hungarian forint', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'IDR', 2, NULL, N'Indonesian rupiah', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ILS', 2, NULL, N'Israeli new shekel', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'INR', 2, NULL, N'Indian rupee', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'IQD', 2, NULL, N'Iraqi dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'IRR', 2, NULL, N'Iranian rial', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ISK', 2, NULL, N'Icelandic kr?na (plural: kr?nur)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'JMD', 2, NULL, N'Jamaican dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'JOD', 2, NULL, N'Jordanian dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'JPY', 2, NULL, N'Japanese yen', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KES', 2, NULL, N'Kenyan shilling', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KGS', 2, NULL, N'Kyrgyzstani som', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KHR', 2, NULL, N'Cambodian riel', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KMF', 2, NULL, N'Comoro franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KPW', 2, NULL, N'North Korean won', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KRW', 2, NULL, N'South Korean won', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KWD', 2, NULL, N'Kuwaiti dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KYD', 2, NULL, N'Cayman Islands dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'KZT', 2, NULL, N'Kazakhstani tenge', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'LAK', 2, NULL, N'Lao kip', N'', N'กีบ', N'อัด')
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'LBP', 2, NULL, N'Lebanese pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'LKR', 2, NULL, N'Sri Lankan rupee', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'LRD', 2, NULL, N'Liberian dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'LSL', 2, NULL, N'Lesotho loti', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'LYD', 2, NULL, N'Libyan dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MAD', 2, NULL, N'Moroccan dirham', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MDL', 2, NULL, N'Moldovan leu', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MGA', 2, NULL, N'Malagasy ariary', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MKD', 2, NULL, N'Macedonian denar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MMK', 2, NULL, N'Myanmar kyat', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MNT', 2, NULL, N'Mongolian t?gr?g', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MOP', 2, NULL, N'Macanese pataca', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MRU', 2, NULL, N'Mauritanian ouguiya', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MUR', 2, NULL, N'Mauritian rupee', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MVR', 2, NULL, N'Maldivian rufiyaa', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MWK', 2, NULL, N'Malawian kwacha', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MXN', 2, NULL, N'Mexican peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MXV', 2, NULL, N'Mexican Unidad de Inversion (UDI) (funds code)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MYR', 2, NULL, N'Malaysian ringgit', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'MZN', 2, NULL, N'Mozambican metical', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'NAD', 2, NULL, N'Namibian dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'NGN', 2, NULL, N'Nigerian naira', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'NIO', 2, NULL, N'Nicaraguan c?rdoba', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'NOK', 2, NULL, N'Norwegian krone', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'NPR', 2, NULL, N'Nepalese rupee', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'NZD', 2, NULL, N'New Zealand dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'OMR', 2, NULL, N'Omani rial', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PAB', 2, NULL, N'Panamanian balboa', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PEN', 2, NULL, N'Peruvian sol', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PGK', 2, NULL, N'Papua New Guinean kina', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PHP', 2, NULL, N'Philippine peso[13]', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PKR', 2, NULL, N'Pakistani rupee', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PLN', 2, NULL, N'Polish z?oty', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'PYG', 2, NULL, N'Paraguayan guaran?', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'QAR', 2, NULL, N'Qatari riyal', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'RON', 2, NULL, N'Romanian leu', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'RSD', 2, NULL, N'Serbian dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'RUB', 2, NULL, N'Russian ruble', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'RWF', 2, NULL, N'Rwandan franc', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SAR', 2, NULL, N'Saudi riyal', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SBD', 2, NULL, N'Solomon Islands dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SCR', 2, NULL, N'Seychelles rupee', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SDG', 2, NULL, N'Sudanese pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SEK', 2, NULL, N'Swedish krona (plural: kronor)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SGD', 2, NULL, N'Singapore dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SHP', 2, NULL, N'Saint Helena pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SLE', 2, NULL, N'Sierra Leonean leone', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SLL', 2, NULL, N'Sierra Leonean leone', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SOS', 2, NULL, N'Somali shilling', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SRD', 2, NULL, N'Surinamese dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SSP', 2, NULL, N'South Sudanese pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'STN', 2, NULL, N'S?o Tom? and Pr?ncipe dobra', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SVC', 2, NULL, N'Salvadoran col?n', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SYP', 2, NULL, N'Syrian pound', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'SZL', 2, NULL, N'Swazi lilangeni', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'THB', 2, NULL, N'Thai baht', N'', N'บาท', N'สตางค์')
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TJS', 2, NULL, N'Tajikistani somoni', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TMT', 2, NULL, N'Turkmenistan manat', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TND', 2, NULL, N'Tunisian dinar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TOP', 2, NULL, N'Tongan pa?anga', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TRY', 2, NULL, N'Turkish lira', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TTD', 2, NULL, N'Trinidad and Tobago dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TWD', 2, NULL, N'New Taiwan dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'TZS', 2, NULL, N'Tanzanian shilling', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'UAH', 2, NULL, N'Ukrainian hryvnia', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'UGX', 2, NULL, N'Ugandan shilling', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'USD', 2, NULL, N'United States dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'USN', 2, NULL, N'United States dollar (next day) (funds code)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'UYI', 2, NULL, N'Uruguay Peso en Unidades Indexadas (URUIURUI) (funds code)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'UYU', 2, NULL, N'Uruguayan peso', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'UYW', 2, NULL, N'Unidad previsional[16]', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'UZS', 2, NULL, N'Uzbekistan som', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'VED', 2, NULL, N'Venezuelan bol?var digital[17]', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'VES', 2, NULL, N'Venezuelan bol?var soberano[13]', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'VND', 2, NULL, N'Vietnamese ??ng', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'VUV', 2, NULL, N'Vanuatu vatu', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'WST', 2, NULL, N'Samoan tala', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XAF', 2, NULL, N'CFA franc BEAC', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XAG', 2, NULL, N'Silver (one troy ounce)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XAU', 2, NULL, N'Gold (one troy ounce)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XBA', 2, NULL, N'European Composite Unit (EURCO) (bond market unit)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XBB', 2, NULL, N'European Monetary Unit (E.M.U.-6) (bond market unit)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XBC', 2, NULL, N'European Unit of Account 9 (E.U.A.-9) (bond market unit)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XBD', 2, NULL, N'European Unit of Account 17 (E.U.A.-17) (bond market unit)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XCD', 2, NULL, N'East Caribbean dollar', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XDR', 2, NULL, N'Special drawing rights', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XOF', 2, NULL, N'CFA franc BCEAO', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XPD', 2, NULL, N'Palladium (one troy ounce)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XPF', 2, NULL, N'CFP franc (franc Pacifique)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XPT', 2, NULL, N'Platinum (one troy ounce)', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XSU', 2, NULL, N'SUCRE', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XTS', 2, NULL, N'Code reserved for testing', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XUA', 2, NULL, N'ADB Unit of Account', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'XXX', 2, NULL, N'No currency', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'YER', 2, NULL, N'Yemeni rial', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ZAR', 2, NULL, N'South African rand', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ZMW', 2, NULL, N'Zambian kwacha', N'', NULL, NULL)
GO
INSERT [dbo].[TCNSRate_L] ([FTRteIsoCode], [FNLngID], [FTFmtCode], [FTRteIsoName], [FTRteIsoRmk], [FTRteUnitName], [FTRteSubUnitName]) VALUES (N'ZWL', 2, NULL, N'Zimbabwean dollar', N'', NULL, NULL)
GO

-- ตาราง TCNSJobTask เก็บข้อมูล การยืนยันอัตราแลกเปลี่ยนรายวัน
IF EXISTS 
  ( SELECT object_id FROM sys.tables
    WHERE name = 'TCNSJobTask'
    AND SCHEMA_NAME(schema_id) = 'dbo'
  )
  BEGIN
   PRINT ('TCNSJobTask : Nothing has changed.')
  END
    
ELSE
	BEGIN
		CREATE TABLE [dbo].[TCNSJobTask](
			[FTAgnCode] [varchar](10) NOT NULL,
			[FTJobRefTbl] [varchar](100) NOT NULL,
			[FDJobDateCfm] [datetime] NULL,
			[FTJobStaUse] [varchar](1) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNSJobTask] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC,
			[FTJobRefTbl] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]
	END
	


-- ตาราง TCNMCountry เก็บข้อมูลมาสเตอร์ประเทศ
IF EXISTS 
  ( SELECT object_id FROM sys.tables
    WHERE name = 'TCNMCountry'
    AND SCHEMA_NAME(schema_id) = 'dbo'
  )
	BEGIN
		PRINT ('TCNMCountry : Nothing has changed.')
    END
ELSE
	BEGIN
		CREATE TABLE [dbo].[TCNMCountry](
			[FTCtyCode] [varchar](5) NOT NULL,
			[FTVatCode] [varchar](5) NOT NULL,
			[FNLngID] [bigint] NOT NULL,
			[FTCtyLongitude] [varchar](50) NULL,
			[FTCtyLatitude] [varchar](50) NULL,
			[FTCtyStaUse] [varchar](1) NULL,
			[FTRteIsoCode] [varchar](5) NULL,
			[FTCtyStaCtrlRate] [varchar](1) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
			[FTCtyRefID] [varchar](5) NULL,
			CONSTRAINT [PK_TCNMCountry] PRIMARY KEY CLUSTERED 
		(
			[FTCtyCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]
	END


-- ตาราง TCNMCountry_L เก็บข้อมูลมาสเตอร์ประเทศ (เก็บชื่อประเทศ)
IF EXISTS 
  ( SELECT object_id FROM sys.tables
    WHERE name = 'TCNMCountry_L'
    AND SCHEMA_NAME(schema_id) = 'dbo'
  )
	BEGIN
	 PRINT ('TCNMCountry_L : Nothing has changed.')
	END
    
ELSE
	BEGIN
		CREATE TABLE [dbo].[TCNMCountry_L](
				[FTCtyCode] [varchar](5) NOT NULL,
				[FNLngID] [bigint] NOT NULL,
				[FTCtyName] [nvarchar](200) NULL,
				[FTCtyRmk] [nvarchar](200) NULL,
			 CONSTRAINT [PK_TCNMCountry_L] PRIMARY KEY CLUSTERED 
			(
				[FTCtyCode] ASC,
				[FNLngID] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
			) ON [PRIMARY]
	END


-- ตาราง TCNMVatRate เก็บข้อมูลอัตราภาษี
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMVatRate'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN
		--เพิ่มคอลัม FTCtyCode : เก็บข้อมูล รหัสประเทศ
		IF COL_LENGTH('TCNMVatRate','FTCtyCode') IS NULL
		BEGIN
			ALTER TABLE TCNMVatRate 
			ADD  FTCtyCode varchar(5) NULL;
		END		
  END
ELSE
    BEGIN
		CREATE TABLE [dbo].[TCNMVatRate](
			[FTVatCode] [varchar](5) NOT NULL,
			[FDVatStart] [datetime] NOT NULL,
			[FCVatRate] [numeric](18, 4) NULL,
			[FTCtyCode] [varchar](5) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNMVatRate] PRIMARY KEY CLUSTERED 
		(
			[FTVatCode] ASC,
			[FDVatStart] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]
	END


-- ตาราง TCNMAgency เก็บข้อมูลตัวแทนขาย
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMAgency'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN
		--เพิ่มคอลัม FTCtyCode : เก็บข้อมูล รหัสประเทศ
		IF COL_LENGTH('TCNMAgency','FTCtyCode') IS NULL
			BEGIN
				ALTER TABLE TCNMAgency 
				ADD  FTCtyCode varchar(5) NULL;
			END
			
  END
ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMAgency](
			[FTAgnCode] [varchar](10) NOT NULL,
			[FTPplCode] [varchar](20) NOT NULL,
			[FTAgnKeyAPI] [varchar](40) NULL,
			[FTAgnPwd] [varchar](30) NULL,
			[FTAgnEmail] [varchar](50) NULL,
			[FTAgnTel] [varchar](50) NULL,
			[FTAgnFax] [varchar](50) NULL,
			[FTAgnMo] [varchar](50) NULL,
			[FTAgnStaApv] [varchar](1) NULL,
			[FTAgnStaActive] [varchar](1) NULL,
			[FTAtyCode] [varchar](5) NULL,
			[FTAggCode] [varchar](5) NULL,
			[FTAgnRefCode] [varchar](20) NULL,
			[FTChnCode] [varchar](5) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
			[FTCtyCode] [varchar](5) NULL,
		 CONSTRAINT [PK_TCNMAgency] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]

	END



-- ตาราง TCNMComp เก็บข้อมูลบริษัท
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMComp'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN
		--เพิ่มคอลัม FTCtyCode : เก็บข้อมูล รหัสประเทศ
		IF COL_LENGTH('TCNMComp','FTCtyCode') IS NULL
			BEGIN
				ALTER TABLE TCNMComp 
				ADD  FTCtyCode varchar(5) NULL;
			END
			
  END
ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMComp](
			[FTCmpCode] [varchar](5) NOT NULL,
			[FTCmpTel] [varchar](50) NULL,
			[FTCmpFax] [varchar](50) NULL,
			[FTBchcode] [varchar](5) NULL,
			[FTCmpWhsInOrEx] [varchar](1) NULL,
			[FTCmpRetInOrEx] [varchar](1) NULL,
			[FTCmpEmail] [varchar](50) NULL,
			[FTRteCode] [varchar](5) NOT NULL,
			[FTVatCode] [varchar](5) NOT NULL,
			[FTCtyCode] [varchar](5) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNMComp] PRIMARY KEY CLUSTERED 
		(
			[FTCmpCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END



-- ตาราง TFNSFmtURL_L เก็บข้อมูล URL Format สำหรับดึงอัตราแลกเปลี่ยน
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TFNSFmtURL_L'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
       TRUNCATE TABLE TFNSFmtURL_L
   END
ELSE
    BEGIN

		CREATE TABLE [dbo].[TFNSFmtURL_L](
			[FTFmtCode] [varchar](5) NOT NULL,
			[FNLngID] [int] NOT NULL,
			[FTFmtType] [varchar](1) NOT NULL,
			[FTFmtName] [varchar](255) NULL,
			[FTFmtStaUse] [varchar](1) NULL,
		 CONSTRAINT [PK_TFNSFmtURL_L] PRIMARY KEY CLUSTERED 
		(
			[FTFmtCode] ASC,
			[FNLngID] ASC,
			[FTFmtType] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]

	END

-- เพิ่มข้อมูล URL Format
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'001', 1, N'1', N'Exchang Rate Base on THB', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'001', 1, N'2', N'Exchang Rate Base on THB', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'002', 1, N'1', N'Exchang Rate Base on LAK', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'002', 1, N'2', N'Exchang Rate Base on LAK', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'003', 1, N'1', N'Exchang Rate Base on USD', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'003', 1, N'2', N'Exchang Rate Base on USD', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'004', 1, N'1', N'Exchang Rate Base on KHR', N'1')
GO
INSERT [dbo].[TFNSFmtURL_L] ([FTFmtCode], [FNLngID], [FTFmtType], [FTFmtName], [FTFmtStaUse]) VALUES (N'004', 1, N'2', N'Exchang Rate Base on KHR', N'1')
GO



-- ตาราง TCNMSlipMsgHD_L เก็บข้อมูล หัวท้ายใบเสร็จ
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMSlipMsgHD_L'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        
		--เพิ่มคอลัม FNLngID : เก็บข้อมูล ฟอนท์ในการพิมพ์ Slip
		IF COL_LENGTH('TCNMSlipMsgHD_L','FTFonts') IS NULL
		BEGIN
			ALTER TABLE TCNMSlipMsgHD_L 
			ADD  FTFonts [nvarchar](255) NULL;
		END

   END
ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMSlipMsgHD_L](
			[FTSmgCode] [varchar](5) NOT NULL,
			[FNLngID] [bigint] NOT NULL,
			[FTSmgTitle] [nvarchar](50) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [nvarchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [nvarchar](20) NULL,
			[FTFonts] [nvarchar](255) NULL,
		CONSTRAINT [PK_TCNMSlipMsgHD_L] PRIMARY KEY CLUSTERED 
		(
			[FTSmgCode] ASC,
			[FNLngID] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END




-- ตาราง TCNMFmtRteSpc เก็บข้อมูล การตั้งค่า URL Format สำหรับดึงอัตราแลกเปลี่ยน ตาม AD
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMFmtRteSpc'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
		PRINT ('TCNMFmtRteSpc : Nothing has changed.')
   END
ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMFmtRteSpc](
			[FTAgnCode] [varchar](20) NOT NULL,
			[FTBchCode] [varchar](5) NOT NULL,
			[FTFspCode] [varchar](5) NOT NULL,
			[FTFmtCode] [varchar](5) NOT NULL,
			[FTFspStaUse] [varchar](1) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TFNMRteSpc] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC,
			[FTBchCode] ASC,
			[FTFspCode] ASC,
			[FTFmtCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]

	END



-- ตาราง TCNMPdt เก็บข้อมูลสินค้า
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMPdt'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN
		--เพิ่มคอลัม FTCtyCode : เก็บข้อมูล รหัสประเทศ
		IF COL_LENGTH('TCNMPdt','FTCtyCode') IS NULL
			BEGIN
				ALTER TABLE TCNMPdt 
				ADD  FTCtyCode varchar(5) NULL;
			END

		--เพิ่มคอลัม FTPdtRefID : รหัสอ้างอิงสินค้า
		IF COL_LENGTH('TCNMPdt','FTPdtRefID') IS NULL
			BEGIN
				ALTER TABLE TCNMPdt 
				ADD  FTPdtRefID [varchar](20) NULL;
			END
			
  END
ELSE
    BEGIN
		CREATE TABLE [dbo].[TCNMPdt](
			[FTPdtCode] [varchar](20) NOT NULL,
			[FTPdtStkControl] [varchar](1) NULL,
			[FTPdtGrpControl] [varchar](1) NULL,
			[FTPdtForSystem] [varchar](30) NULL,
			[FCPdtQtyOrdBuy] [numeric](18, 4) NULL,
			[FCPdtCostDef] [numeric](18, 4) NULL,
			[FCPdtCostOth] [numeric](18, 4) NULL,
			[FCPdtCostStd] [numeric](18, 4) NULL,
			[FCPdtMin] [numeric](18, 4) NULL,
			[FCPdtMax] [numeric](18, 4) NULL,
			[FTPdtPoint] [varchar](1) NULL,
			[FCPdtPointTime] [numeric](18, 4) NULL,
			[FTPdtType] [varchar](1) NULL,
			[FTPdtSaleType] [varchar](1) NULL,
			[FTPdtSetOrSN] [varchar](1) NULL,
			[FTPdtStaSetPri] [varchar](1) NULL,
			[FTPdtStaSetShwDT] [varchar](1) NULL,
			[FTPdtStaAlwDis] [varchar](1) NULL,
			[FTPdtStaAlwReturn] [varchar](1) NULL,
			[FTPdtStaVatBuy] [varchar](1) NULL,
			[FTPdtStaVat] [varchar](1) NULL,
			[FTPdtStaActive] [varchar](1) NULL,
			[FTPdtStaAlwReCalOpt] [varchar](1) NULL,
			[FTPdtStaCsm] [varchar](1) NULL,
			[FTTcgCode] [varchar](5) NULL,
			[FTPgpChain] [varchar](30) NULL,
			[FTPtyCode] [varchar](5) NULL,
			[FTPbnCode] [varchar](5) NULL,
			[FTPmoCode] [varchar](5) NULL,
			[FTVatCode] [varchar](5) NULL,
			[FTEvhCode] [varchar](5) NULL,
			[FTCtyCode] [varchar](5) NULL,
			[FDPdtSaleStart] [datetime] NULL,
			[FDPdtSaleStop] [datetime] NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
			[FTPdtRefID] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNMPdt] PRIMARY KEY CLUSTERED 
		(
			[FTPdtCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]
	END






-- ตาราง TCNSFonts เก็บข้อมูล Fonts
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNSFonts'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
      TRUNCATE TABLE TCNSFonts
   END
ELSE
    BEGIN
		CREATE TABLE [dbo].[TCNSFonts](
			[FTFntID] [int] IDENTITY(1,1) NOT NULL,
			[FTAppCode] [varchar](5) NOT NULL,
			[FTFntName] [varchar](100) NULL,
			[FTFntDesc] [varchar](100) NULL,
			[FTFntStause] [varchar](1) NULL,
		 CONSTRAINT [PK_TCNSFonts] PRIMARY KEY CLUSTERED 
		(
			[FTFntID] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]
	END


-- เพิ่มข้อมูล Fonts
SET IDENTITY_INSERT [dbo].[TCNSFonts] ON 
GO
INSERT [dbo].[TCNSFonts] ([FTFntID], [FTAppCode], [FTFntName], [FTFntDesc], [FTFntStause]) VALUES (1, N'', N'BoonHome', NULL, N'1')
GO
INSERT [dbo].[TCNSFonts] ([FTFntID], [FTAppCode], [FTFntName], [FTFntDesc], [FTFntStause]) VALUES (5, N'', N'CordiaUPC', NULL, N'1')
GO
INSERT [dbo].[TCNSFonts] ([FTFntID], [FTAppCode], [FTFntName], [FTFntDesc], [FTFntStause]) VALUES (6, N'', N'Tahoma', NULL, N'1')
GO
SET IDENTITY_INSERT [dbo].[TCNSFonts] OFF
GO




-- ตาราง TFNMRcv เก็บข้อมูล ประเภทการชำระเงิน
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TFNMRcv'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
       -- สถานะอนุญาต ชำระหลายสกุลเงิน
       IF COL_LENGTH('TFNMRcv','FTRcvStaAllRte') IS NULL
		   BEGIN
			   ALTER TABLE TFNMRcv 
			   ADD FTRcvStaAllRte  [varchar](1) NULL;
		   END

	   -- รหัสอ้างอิงสกุลเงิน กรณีผูกสกุลเงินกับปุ่ม
       IF COL_LENGTH('TFNMRcv','FTRcvRefRate') IS NULL
		   BEGIN
			   ALTER TABLE TFNMRcv 
			   ADD [FTRcvRefRate] [varchar](5) NULL;
		   END

   END
ELSE
    BEGIN
		CREATE TABLE [dbo].[TFNMRcv](
			[FTRcvCode] [varchar](5) NOT NULL,
			[FTFmtCode] [varchar](5) NULL,
			[FTRcvStaUse] [varchar](1) NULL,
			[FTRcvStaShwInSlip] [varchar](1) NULL,
			[FTRcv4Ret] [varchar](5) NULL,
			[FTRcv4ChkOut] [varchar](5) NULL,
			[FTAppStaAlwRet] [varchar](1) NULL,
			[FTRcvStaAllRte] [varchar](1) NULL,
			[FTAppStaAlwCancel] [varchar](1) NULL,
			[FTAppStaPayLast] [varchar](1) NULL,
			[FTRcvRefRate] [varchar](5) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TFNMRcv] PRIMARY KEY CLUSTERED 
		(
			[FTRcvCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]
	END



-- ตาราง TCNMBranch เก็บข้อมูลสาขา
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMBranch'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
       -- เพิ่มรหัสประเทศ
       IF COL_LENGTH('TCNMBranch','FTCtyCode') IS NULL
		   BEGIN
			   ALTER TABLE TCNMBranch 
			   ADD [FTCtyCode] [varchar](10) NULL;
		   END
   END
ELSE
    BEGIN
		CREATE TABLE [dbo].[TCNMBranch](
			[FTBchCode] [varchar](5) NOT NULL,
			[FTPplCode] [varchar](20) NOT NULL,
			[FTBchType] [varchar](1) NULL,
			[FTBchPriority] [varchar](1) NULL,
			[FTBchRegNo] [varchar](30) NULL,
			[FTBchRefID] [varchar](30) NULL,
			[FDBchStart] [datetime] NULL,
			[FDBchStop] [datetime] NULL,
			[FDBchSaleStart] [datetime] NULL,
			[FDBchSaleStop] [datetime] NULL,
			[FTBchStaHQ] [varchar](1) NULL,
			[FTBchStaActive] [varchar](1) NULL,
			[FTWahCode] [varchar](5) NOT NULL,
			[FNBchDefLang] [int] NULL,
			[FTBchUriSrvMQ] [varchar](200) NULL,
			[FTBchUriSrvSG] [varchar](200) NULL,
			[FTMerCode] [varchar](10) NULL,
			[FTAgnCode] [varchar](10) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
			[FTCtyCode] [varchar](10) NULL,
		 CONSTRAINT [PK_TCNMBranch] PRIMARY KEY CLUSTERED 
		(
			[FTBchCode] ASC

		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]
	END




-- ตาราง TFNMRate_L เก็บข้อมูลสกุลเงิน (L)
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TFNMRate_L'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        
		-- เพิ่มตัวแทนจำหน่าย PK
		IF COL_LENGTH('TFNMRate_L','FTAgnCode') IS  NULL
			BEGIN
				ALTER TABLE TFNMRate_L 
				ADD  FTAgnCode [varchar](10)  NOT NULL
				CONSTRAINT FTAgnCode_R DEFAULT ''
				WITH VALUES
			END

		-- Drop Primary Key
		DECLARE @table NVARCHAR(512), @sql NVARCHAR(MAX);
		SELECT @table = N'dbo.TFNMRate_L';
		SELECT @sql = 'ALTER TABLE ' + @table 
			+ ' DROP CONSTRAINT ' + name + ';'
			FROM sys.key_constraints
			WHERE [type] = 'PK'
			AND [parent_object_id] = OBJECT_ID(@table);

		EXEC sp_executeSQL @sql;

		-- Create Primary Key
		ALTER TABLE TFNMRate_L
		ADD  CONSTRAINT [PK_TFNMRate_L] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC,
			[FTRteCode] ASC,
			[FNLngID] ASC
		)

   END

ELSE
    BEGIN

		CREATE TABLE [dbo].[TFNMRate_L](
			[FTAgnCode] [varchar](10) NOT NULL,
			[FTRteCode] [varchar](5) NOT NULL,
			[FNLngID] [bigint] NOT NULL,
			[FTRteName] [nvarchar](100) NULL,
			[FTRteShtName] [nvarchar](10) NULL,
			[FTRteNameText] [nvarchar](50) NULL,
			[FTRteDecText] [nvarchar](50) NULL,
		 CONSTRAINT [PK_TFNMRate_L] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC,
			[FTRteCode] ASC,
			[FNLngID] ASC

		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END




-- ตาราง TFNMRateUnit เก็บข้อมูลหน่วยย่อยสกุลเงิน
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TFNMRateUnit'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        
		-- เพิ่มตัวแทนจำหน่าย
		IF COL_LENGTH('TFNMRateUnit','FTAgnCode') IS  NULL
			BEGIN
				ALTER TABLE TFNMRateUnit 
				ADD  FTAgnCode [varchar](10)  NOT NULL
				CONSTRAINT FTAgnCode_RU DEFAULT ''
				WITH VALUES
			END

		-- Drop Primary Key
		DECLARE @table1 NVARCHAR(512), @sql1 NVARCHAR(MAX);
		SELECT @table1 = N'dbo.TFNMRateUnit';
		SELECT @sql1 = 'ALTER TABLE ' + @table1 
			+ ' DROP CONSTRAINT ' + name + ';'
			FROM sys.key_constraints
			WHERE [type] = 'PK'
			AND [parent_object_id] = OBJECT_ID(@table1);

		EXEC sp_executeSQL @sql1;

		-- Create Primary Key
		ALTER TABLE TFNMRateUnit
		ADD  CONSTRAINT [PK_TFNMRateUnit] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC,
			[FTRteCode] ASC,
			[FNRtuSeq] ASC
		)

   END

ELSE
    BEGIN

		CREATE TABLE [dbo].[TFNMRateUnit](
			[FTAgnCode] [varchar](10) NOT NULL,
			[FTRteCode] [varchar](5) NOT NULL,
			[FNRtuSeq] [int] NOT NULL,
			[FCRtuFac] [numeric](18, 4) NULL,
		 CONSTRAINT [PK_TFNMRateUnit] PRIMARY KEY CLUSTERED 
		(
			[FTAgnCode] ASC,
			[FTRteCode] ASC,
			[FNRtuSeq] ASC

		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END




-- TCNMZone : ตารางเก็บข้อมูล โซน
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMZone'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        
		-- เพิ่มตัวแทนจำหน่าย
		IF COL_LENGTH('TCNMZone','FTAgnCode') IS  NULL
			BEGIN
				ALTER TABLE TCNMZone 
				ADD  FTAgnCode [varchar](10)  NOT NULL
				CONSTRAINT FTAgnCode_Z DEFAULT ''
				WITH VALUES
			END

		-- Drop Primary Key
		DECLARE @tableZone NVARCHAR(512), @sqlZone NVARCHAR(MAX);
		SELECT @tableZone = N'dbo.TCNMZone';
		SELECT @sqlZone = 'ALTER TABLE ' + @tableZone 
			+ ' DROP CONSTRAINT ' + name + ';'
			FROM sys.key_constraints
			WHERE [type] = 'PK'
			AND [parent_object_id] = OBJECT_ID(@tableZone);

		EXEC sp_executeSQL @sqlZone;

		-- Create Primary Key
		ALTER TABLE TCNMZone
		ADD  CONSTRAINT [PK_TCNMZone] PRIMARY KEY CLUSTERED 
		(
			[FTZneChain] ASC,
			[FTAgnCode] ASC,
			[FTZneCode] ASC
		)

   END

ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMZone](
			[FTAgnCode] [varchar](20) NOT NULL,
			[FTZneChain] [varchar](30) NOT NULL,
			[FTZneCode] [varchar](5) NOT NULL,
			[FNZneLevel] [int] NOT NULL,
			[FTZneParent] [varchar](5) NOT NULL,
			[FTAreCode] [varchar](5) NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNMZone] PRIMARY KEY CLUSTERED 
		(
			[FTZneChain] ASC,
			[FTAgnCode] ASC,
			[FTZneCode] ASC

		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END




-- TCNMZone_L : เก็บข้อมูลโซน (L)
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMZone_L'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        
		-- เพิ่มตัวแทนจำหน่าย
		IF COL_LENGTH('TCNMZone_L','FTAgnCode') IS  NULL
			BEGIN
				ALTER TABLE TCNMZone_L 
				ADD  FTAgnCode [varchar](10)  NULL
				CONSTRAINT FTAgnCode_ZL DEFAULT ''
				WITH VALUES
			END
   END

ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMZone_L](
			[FTZneChain] [varchar](30) NOT NULL,
			[FNLngID] [bigint] NOT NULL,
			[FTZneName] [nvarchar](100) NULL,
			[FTZneCode] [nvarchar](255) NULL,
			[FTZneChainName] [nvarchar](255) NULL,
			[FTZneRmk] [nvarchar](200) NULL,
			[FTAgnCode] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNMZone_L] PRIMARY KEY CLUSTERED 
		(
			[FTZneChain] ASC,
			[FNLngID] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END





-- TCNMZoneObj : เก็บข้อมูลที่ที่นำมาผูกกับโซน เช่น ประเทศ สาขา etc.
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMZoneObj'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        
		-- เพิ่มตัวแทนจำหน่าย
		IF COL_LENGTH('TCNMZoneObj','FTAgnCode') IS  NULL
			BEGIN
				ALTER TABLE TCNMZoneObj 
				ADD  FTAgnCode [varchar](10)  NULL
				CONSTRAINT FTAgnCode_ZOBJ DEFAULT ''
				WITH VALUES
			END
   END

ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNMZoneObj](
			[FNZneID] [bigint] IDENTITY(1,1) NOT NULL,
			[FTAgnCode] [varchar](20) NULL,
			[FTZneRefCode] [varchar](20) NULL,
			[FTZneTable] [varchar](50) NULL,
			[FTZneKey] [varchar](20) NULL,
			[FNZneSeq] [int] NULL,
			[FTZneChain] [varchar](30) NOT NULL,
			[FDLastUpdOn] [datetime] NULL,
			[FTLastUpdBy] [varchar](20) NULL,
			[FDCreateOn] [datetime] NULL,
			[FTCreateBy] [varchar](20) NULL,
		 CONSTRAINT [PK_TCNMZoneObj] PRIMARY KEY CLUSTERED 
		(
			[FNZneID] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [AdaPos5_MAS_Filegroups]
		) ON [AdaPos5_MAS_Filegroups]

	END




-- TCNTPdtPmtHDZne : เก็บข้อมูล กำหนดโปรโมชั่นพิเศษใช้ได้เฉพาะโซน
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNTPdtPmtHDZne'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
        PRINT ('TCNTPdtPmtHDZne : Nothing has changed.')
   END

ELSE
    BEGIN

		CREATE TABLE [dbo].[TCNTPdtPmtHDZne](
			[FTPmhDocNo] [varchar](20) NOT NULL,
			[FTPmhStaType] [varchar](1) NOT NULL,
			[FTZneCode] [varchar](5) NOT NULL,
			[FTZneChain] [varchar](30) NOT NULL,
			[FTBchCode] [varchar](5) NOT NULL,
		 CONSTRAINT [PK_TCNTPdtPmtHDZne] PRIMARY KEY CLUSTERED 
		(
			[FTPmhDocNo] ASC,
			[FTPmhStaType] ASC,
			[FTZneCode] ASC,
			[FTZneChain] ASC,
			[FTBchCode] ASC
		)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
		) ON [PRIMARY]

	END




-- TCNMPdt_L : เปลี่ยน DataType varchar To nvarchar
IF EXISTS 
	( SELECT object_id FROM sys.tables
	WHERE name = 'TCNMPdt_L'
	AND SCHEMA_NAME(schema_id) = 'dbo'
	)
BEGIN	
    -- เปลี่ยน DataType FTPdtName To nvarchar
    IF COL_LENGTH('TCNMPdt_L','FTPdtName') IS NOT NULL
		BEGIN
			ALTER TABLE TCNMPdt_L 
			ALTER COLUMN FTPdtName nvarchar(100);
		END

	-- เปลี่ยน DataType FTPdtNameOth To nvarchar
    IF COL_LENGTH('TCNMPdt_L','FTPdtNameOth') IS NOT NULL
		BEGIN
			ALTER TABLE TCNMPdt_L 
			ALTER COLUMN FTPdtNameOth nvarchar(100);
		END

	-- เปลี่ยน DataType FTPdtNameABB To nvarchar
    IF COL_LENGTH('TCNMPdt_L','FTPdtNameABB') IS NOT NULL
		BEGIN
			ALTER TABLE TCNMPdt_L 
			ALTER COLUMN FTPdtNameABB nvarchar(50);
		END

	-- เปลี่ยน DataType FTPdtRmk To nvarchar
    IF COL_LENGTH('TCNMPdt_L','FTPdtRmk') IS NOT NULL
		BEGIN
			ALTER TABLE TCNMPdt_L 
			ALTER COLUMN FTPdtRmk nvarchar(200);
		END
END




-- TCNMCst_L : เปลี่ยน DataType varchar To nvarchar
IF EXISTS 
	  ( SELECT object_id FROM sys.tables
		WHERE name = 'TCNMCst_L'
		AND SCHEMA_NAME(schema_id) = 'dbo'
	  )
   BEGIN	
       -- เปลี่ยน DataType FTCstName To nvarchar
       IF COL_LENGTH('TCNMCst_L','FTCstName') IS NOT NULL
			BEGIN
				ALTER TABLE TCNMCst_L 
				ALTER COLUMN FTCstName nvarchar(200);
			END

	   -- เปลี่ยน DataType FTCstNameOth To nvarchar
       IF COL_LENGTH('TCNMCst_L','FTCstNameOth') IS NOT NULL
			BEGIN
				ALTER TABLE TCNMCst_L 
				ALTER COLUMN FTCstNameOth nvarchar(200);
			END

	  -- เปลี่ยน DataType FTCstRmk To nvarchar
      IF COL_LENGTH('TCNMCst_L','FTCstRmk') IS NOT NULL
			BEGIN
				ALTER TABLE TCNMCst_L 
				ALTER COLUMN FTCstRmk nvarchar(50);
			END
   END


-- TCNMPdt : Update รหัสอ้างอิงสินค้า
UPDATE TCNMPdt SET FTPdtRefID = FTPdtCode
WHERE ISNULL(FTPdtRefID,'') = ''


-- 8. Innitial ข้อมูลประเทศ 
IF NOT EXISTS(SELECT FTCtyCode FROM TCNMCountry WHERE FTCtyCode = 'THA') 
BEGIN
	INSERT [dbo].[TCNMCountry] ([FTCtyCode], [FTVatCode], [FNLngID], [FTCtyLongitude], [FTCtyLatitude], [FTCtyStaUse], [FTRteIsoCode], [FTCtyStaCtrlRate], [FDLastUpdOn], [FTLastUpdBy], [FDCreateOn], [FTCreateBy], [FTCtyRefID]) VALUES (N'THA', N'00001', 1, N'', N'', N'1', N'THB', N'2', CAST(N'2022-09-22T14:39:24.000' AS DateTime), N'00001', CAST(N'2022-09-22T14:39:24.000' AS DateTime), N'00001', N'THA')
	INSERT [dbo].[TCNMCountry_L] ([FTCtyCode], [FNLngID], [FTCtyName], [FTCtyRmk]) VALUES (N'THA', 1, N'ประเทศไทย', NULL)
END

-- 1. สินค้า (เดิม) ไม่มี Update  CtyCode
UPDATE  TCNMPDT SET FTCtyCode = 'THA' WHERE ISNULL(FTCtyCode,'') = ''

-- 2. Agency (เดิม) ไม่มี Update  CtyCode
UPDATE  TCNMAgency SET FTCtyCode = 'THA' WHERE ISNULL(FTCtyCode,'') = ''

-- 3.  Branch (เดิม) ไม่มี Update  CtyCode
UPDATE  TCNMBranch SET FTCtyCode = 'THA' WHERE ISNULL(FTCtyCode,'') = ''

-- 4.  ราคา ประเทศไทยเดิม ต้อง Update กลุ่มราคา (TH)
IF NOT EXISTS(SELECT FTPplCode FROM TCNMPdtPriList WHERE FTPplCode = 'TH') 
	BEGIN

		INSERT INTO TCNMPdtPriList ( FTPplCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy )
		VALUES(N'TH',GETDATE(),'System',GETDATE(),'System')

		INSERT INTO TCNMPdtPriList_L( FTPplCode,FNLngID,FTPplName,FTPplRmk)
		VALUES(N'TH',1,N'กลุ่มราคาประเทศไทย','กลุ่มราคานี้ใช้ในประเทศไทย')
	END

UPDATE  TCNTPdtPrice4PDT SET FTPplCode = 'TH' , FDLastUpdOn = GETDATE() WHERE ISNULL(FTPplCode,'') = ''


-- 5. Promotion ของเดิม ต้องผูก Zone (ประเทศไทย)
IF NOT EXISTS(SELECT FTZneCode FROM TCNMZone WHERE FTZneCode = '00001') 
	BEGIN
	    INSERT INTO TCNMZone (FTAgnCode,FTZneChain,FTZneCode,FNZneLevel,FTZneParent,FTAreCode,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
		VALUES ('','00001','00001','1','','',GETDATE(),N'System',GETDATE(),N'System')

		INSERT INTO TCNMZone_L (FTZneChain,FNLngID,FTZneName,FTZneCode,FTZneChainName,FTZneRmk,FTAgnCode)
		VALUES ('00001',1,N'โซนประเทศไทย','00001',N'โซนประเทศไทย','','')
	END

-- Insert Promotion Zone
INSERT INTO TCNTPdtPmtHDZne
SELECT PMT.FTPmhDocNo, '1' AS FTPmhStaType,'00001','00001',PMT.FTBchCode
FROM TCNTPdtPmtHD PMT WITH(NOLOCK)
LEFT JOIN TCNTPdtPmtHDZne ZNE WITH(NOLOCK) ON PMT.FTBchCode = ZNE.FTBchCode AND PMT.FTPmhDocNo = ZNE.FTPmhDocNo
WHERE ISNULL(ZNE.FTPmhDocNo,'') = ''

IF NOT EXISTS(SELECT FTMnuCode FROM TSysMenuList WHERE FTMnuCode = 'SET003' AND FTGmnCode = 'ARS' AND FTGmnModCode = 'AR') 
BEGIN
	INSERT INTO [TSysMenuList]([FTGmnCode], [FTMnuParent], [FTMnuCode], [FNMnuSeq], [FTMnuCtlName], [FNMnuLevel], [FTMnuStaPosHpm], [FTMnuStaPosFhn], [FTMnuStaSmartHpm], [FTMnuStaSmartFhn], [FTMnuStaMoreHpm], [FTMnuStaMoreFhn], [FTMnuType], [FTMnuStaAPIPos], [FTMnuStaAPISmart], [FTMnuStaUse], [FTMnuPath], [FTGmnModCode], [FTMnuImgPath]) VALUES ('ARS', 'ARS', 'SET003', 3, 'SettingDailyCurrency/0/0', 0, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', '1', 'Y', 'Y', '1', '', 'AR', '')
	INSERT INTO [TSysMenuList_L]([FTMnuCode], [FNLngID], [FTMnuName], [FTMnuRmk]) VALUES ('SET003', 1, N'อัตราแลกเปลี่ยนสกุลเงินรายวัน', N'อัตราแลกเปลี่ยนสกุลเงินรายวัน')
	INSERT INTO [TSysMenuList_L]([FTMnuCode], [FNLngID], [FTMnuName], [FTMnuRmk]) VALUES ('SET003', 2, N'Daily currency exchange rate', N'Daily currency exchange rate')
	INSERT INTO [TSysMenuAlbAct]([FTMnuCode], [FTAutStaRead], [FTAutStaAdd], [FTAutStaEdit], [FTAutStaDelete], [FTAutStaCancel], [FTAutStaAppv], [FTAutStaPrint], [FTAutStaPrintMore]) VALUES ('SET003', '1', '1', '1', '1', '0', '0', '0', '0')
END
GO

IF NOT EXISTS(SELECT FTMnuCode FROM TSysMenuList WHERE FTMnuCode = 'CON001' AND FTGmnCode = 'SYS' AND FTGmnModCode = 'MAS') 
BEGIN
	INSERT INTO [TSysMenuList]([FTGmnCode], [FTMnuParent], [FTMnuCode], [FNMnuSeq], [FTMnuCtlName], [FNMnuLevel], [FTMnuStaPosHpm], [FTMnuStaPosFhn], [FTMnuStaSmartHpm], [FTMnuStaSmartFhn], [FTMnuStaMoreHpm], [FTMnuStaMoreFhn], [FTMnuType], [FTMnuStaAPIPos], [FTMnuStaAPISmart], [FTMnuStaUse], [FTMnuPath], [FTGmnModCode], [FTMnuImgPath]) VALUES ('SYS', 'SYS', 'CON001', 2, 'country/0/0', 1, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', '1', 'Y', 'Y', '1', ' ', 'MAS', ' ')
	INSERT INTO [TSysMenuList_L]([FTMnuCode], [FNLngID], [FTMnuName], [FTMnuRmk]) VALUES ('CON001', 1, N'ประเทศ', N'ประเทศ')
	INSERT INTO [TSysMenuList_L]([FTMnuCode], [FNLngID], [FTMnuName], [FTMnuRmk]) VALUES ('CON001', 2, N'Country', N'Country')
	INSERT INTO [TSysMenuAlbAct]([FTMnuCode], [FTAutStaRead], [FTAutStaAdd], [FTAutStaEdit], [FTAutStaDelete], [FTAutStaCancel], [FTAutStaAppv], [FTAutStaPrint], [FTAutStaPrintMore]) VALUES ('CON001', '1', '1', '1', '1', '0', '0', '0', '0')
END
GO

IF NOT EXISTS(SELECT FTMnuCode FROM TSysMenuList WHERE FTMnuCode = 'STO004' AND FTGmnCode = 'SYS' AND FTGmnModCode = 'MAS') 
BEGIN
	INSERT INTO [TSysMenuList]([FTGmnCode], [FTMnuParent], [FTMnuCode], [FNMnuSeq], [FTMnuCtlName], [FNMnuLevel], [FTMnuStaPosHpm], [FTMnuStaPosFhn], [FTMnuStaSmartHpm], [FTMnuStaSmartFhn], [FTMnuStaMoreHpm], [FTMnuStaMoreFhn], [FTMnuType], [FTMnuStaAPIPos], [FTMnuStaAPISmart], [FTMnuStaUse], [FTMnuPath], [FTGmnModCode], [FTMnuImgPath]) VALUES ('SYS', 'SYS', 'STO004', 3, 'zone/0/0', 1, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', '1', 'Y', 'Y', '1', ' ', 'MAS', ' ');
	INSERT INTO [TSysMenuList_L]([FTMnuCode], [FNLngID], [FTMnuName], [FTMnuRmk]) VALUES ('STO004', 1, N'โซน', N'ข้อมูลสาขา');
	INSERT INTO [TSysMenuList_L]([FTMnuCode], [FNLngID], [FTMnuName], [FTMnuRmk]) VALUES ('STO004', 2, N'Zone', N'System Branch');
	INSERT INTO [TSysMenuAlbAct]([FTMnuCode], [FTAutStaRead], [FTAutStaAdd], [FTAutStaEdit], [FTAutStaDelete], [FTAutStaCancel], [FTAutStaAppv], [FTAutStaPrint], [FTAutStaPrintMore]) VALUES ('STO004', '1', '1', '1', '1', '0', '0', '0', '0');
END
GO

/****** Object:  Table [dbo].[TCNTPdtPmtHDZneTmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDZneTmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDZne_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDZne_Tmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDCstPriTmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDCstPriTmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDCstPri_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDCstPri_Tmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDChnTmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDChnTmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDChn_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDChn_Tmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDBchTmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDBchTmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDBch_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
DROP TABLE IF EXISTS [dbo].[TCNTPdtPmtHDBch_Tmp]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDBch_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDBch_Tmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTPmhBchTo] [varchar](5) NOT NULL,
	[FTPmhMerTo] [varchar](10) NOT NULL,
	[FTPmhShpTo] [varchar](5) NOT NULL,
	[FTPmhBchToName] [varchar](100) NULL,
	[FTPmhMerToName] [varchar](50) NULL,
	[FTPmhShpToName] [varchar](50) NULL,
	[FTPmhStaType] [varchar](1) NULL,
	[FTSessionID] [varchar](255) NOT NULL,
	[FDCreateOn] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDBchTmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDBchTmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTPmhBchTo] [varchar](5) NOT NULL,
	[FTPmhMerTo] [varchar](10) NOT NULL,
	[FTPmhShpTo] [varchar](5) NOT NULL,
	[FTPmhStaType] [varchar](1) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDChn_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDChn_Tmp](
	[FTBchCode] [varchar](5) NULL,
	[FTPmhDocNo] [varchar](20) NULL,
	[FTChnCode] [varchar](5) NULL,
	[FTChnName] [varchar](50) NULL,
	[FTPmhStaType] [varchar](1) NULL,
	[FTSessionID] [varchar](255) NULL,
	[FDCreateOn] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDChnTmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDChnTmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTChnCode] [varchar](5) NOT NULL,
	[FTPmhStaType] [varchar](1) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDCstPri_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDCstPri_Tmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTPplCode] [varchar](20) NOT NULL,
	[FTPplName] [varchar](50) NULL,
	[FTPmhStaType] [varchar](1) NULL,
	[FTSessionID] [varchar](255) NOT NULL,
	[FDCreateOn] [datetime] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDCstPriTmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDCstPriTmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTPplCode] [varchar](20) NOT NULL,
	[FTPmhStaType] [varchar](1) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDZne_Tmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDZne_Tmp](
	[FTPmhDocNo] [varchar](20) NULL,
	[FTPmhStaType] [varchar](1) NULL,
	[FTZneCode] [varchar](5) NULL,
	[FTZneChain] [varchar](30) NULL,
	[FTSessionID] [varchar](255) NULL,
	[FDCreateOn] [datetime] NULL,
	[FTZneName] [varchar](255) NULL,
	[FTBchCode] [varchar](5) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TCNTPdtPmtHDZneTmp]    Script Date: 18/10/2565 20:01:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TCNTPdtPmtHDZneTmp](
	[FTPmhDocNo] [varchar](20) NOT NULL,
	[FTPmhStaType] [varchar](1) NOT NULL,
	[FTZneCode] [varchar](5) NOT NULL,
	[FTZneChain] [varchar](30) NOT NULL,
	[FTBchCode] [varchar](5) NOT NULL
) ON [PRIMARY]
GO

-- ปรับ size ของ column FTPmhBchToName 
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns WHERE TABLE_NAME = 'TCNTPdtPmtHDBch_Tmp' AND COLUMN_NAME = 'FTPmhBchToName') 
	BEGIN
	 ALTER TABLE TCNTPdtPmtHDBch_Tmp 
	 ADD FTPmhBchToName varchar(100) COLLATE Thai_CI_AS NULL 
	END
ELSE
	BEGIN
	 ALTER TABLE TCNTPdtPmtHDBch_Tmp 
	 ALTER COLUMN FTPmhMerToName varchar(100) COLLATE Thai_CI_AS NULL 
	END
GO

-- ปรับ size ของ column FTPmhMerToName 
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns WHERE TABLE_NAME = 'TCNTPdtPmtHDBch_Tmp' AND COLUMN_NAME = 'FTPmhMerToName') 
	BEGIN
	 ALTER TABLE TCNTPdtPmtHDBch_Tmp 
	 ADD FTPmhMerToName varchar(200) COLLATE Thai_CI_AS NULL 
	END
ELSE
	BEGIN
	 ALTER TABLE TCNTPdtPmtHDBch_Tmp 
	 ALTER COLUMN FTPmhMerToName varchar(200) COLLATE Thai_CI_AS NULL 
	END
GO

-- ปรับ size ของ column FTPmhShpToName 
IF NOT EXISTS(SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns WHERE TABLE_NAME = 'TCNTPdtPmtHDBch_Tmp' AND COLUMN_NAME = 'FTPmhShpToName') 
	BEGIN
	 ALTER TABLE TCNTPdtPmtHDBch_Tmp 
	 ADD FTPmhShpToName varchar(100) COLLATE Thai_CI_AS NULL 
	END
ELSE
	BEGIN
	 ALTER TABLE TCNTPdtPmtHDBch_Tmp 
	 ALTER COLUMN FTPmhShpToName varchar(100) COLLATE Thai_CI_AS NULL 
	END
GO


IF EXISTS 
	( SELECT object_id FROM sys.tables
	WHERE name = 'TCNMSlipMsgDT_L'
	AND SCHEMA_NAME(schema_id) = 'dbo'
	)
BEGIN	
    -- เปลี่ยน DataType FTSmgName To nvarchar
    IF COL_LENGTH('TCNMSlipMsgDT_L','FTSmgName') IS NOT NULL
		BEGIN
			ALTER TABLE TCNMSlipMsgDT_L 
			ALTER COLUMN FTSmgName nvarchar(50);
		END
END
GO
-- Script By Nauy
IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig WITH(NOLOCK)
          WHERE FTSysCode = 'bPS_AlwChkCstPDPA' 
		  AND FTSysApp = 'CN' 
		  AND FTSysKey = 'ALL' 
		  AND FTSysSeq = '1')
BEGIN
	INSERT INTO TSysConfig (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FTGmnCode,FTSysStaAlwEdit,FTSysStaDataType,FNSysMaxLength,FTSysStaDefValue,FTSysStaDefRef,FTSysStaUsrValue,FTSysStaUsrRef,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy)
	VALUES ('bPS_AlwChkCstPDPA','CN','ALL','1','MPOS','1','4','1','1','','1','','2022-09-12 02:40:39.000','00001','2020-08-13 00:00:00.000','')
END
GO

IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig_L WITH(NOLOCK)
			  WHERE FTSysCode = 'bPS_AlwChkCstPDPA' 
			  AND FTSysApp = 'CN' 
			  AND FTSysKey = 'ALL' 
			  AND FTSysSeq = '1'
			  AND FNLngID = 1)
BEGIN
		INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
		VALUES ('bPS_AlwChkCstPDPA','CN','ALL','1','1','อนุญาติ ตรวจสอบความยินยอมให้ใช้ข้อมูลส่วนบุคคลของลูกค้า(PDPA)','1 : อนุญาต, 0 : ไม่อนุญาต','')
END
GO

IF NOT EXISTS(SELECT 1 FROM dbo.TSysConfig_L WITH(NOLOCK)
			WHERE FTSysCode = 'bPS_AlwChkCstPDPA' 
			AND FTSysApp = 'CN' 
			AND FTSysKey = 'ALL' 
			AND FTSysSeq = '1'
			AND FNLngID = 1)
BEGIN
		INSERT INTO TSysConfig_L (FTSysCode,FTSysApp,FTSysKey,FTSysSeq,FNLngID,FTSysName,FTSysDesc,FTSysRmk)
		VALUES ('bPS_AlwChkCstPDPA','CN','ALL','1','2','Permission Checking Customer Consent to Use of Personal Data (PDPA)','1 : Allow, 0 : Not  Allow','')
END
GO

-- เพิ่ม language ลาว ใน TSysLanguage
IF NOT EXISTS(SELECT FNLngID FROM TSysLanguage WHERE FNLngID = '4') 
	BEGIN
	    INSERT INTO [dbo].[TSysLanguage] ([FNLngID], [FTLngName], [FTLngNameEng], [FTLngShortName], [FTLngStaLocal], [FTLngStaUse]) 
		VALUES (4, 'ลาว', 'Laos', 'LAO', '2', '1');
	END
GO
-- เพิ่ม language เวียดนาม ใน TSysLanguage
IF NOT EXISTS(SELECT FNLngID FROM TSysLanguage WHERE FNLngID = '5') 
	BEGIN
	   INSERT INTO [dbo].[TSysLanguage] ([FNLngID], [FTLngName], [FTLngNameEng], [FTLngShortName], [FTLngStaLocal], [FTLngStaUse]) 
	   VALUES (5, 'เวียดนาม', 'Vietnam', 'VIE', '2', '2');
	END
GO
-- เพิ่ม language  ัมพูชา ใน TSysLanguage
IF NOT EXISTS(SELECT FNLngID FROM TSysLanguage WHERE FNLngID = '6') 
	BEGIN
	    INSERT INTO [dbo].[TSysLanguage] ([FNLngID], [FTLngName], [FTLngNameEng], [FTLngShortName], [FTLngStaLocal], [FTLngStaUse])
		VALUES (6, 'กัมพูชา', 'Cambodia', 'KHM', '2', '2');
	END
GO