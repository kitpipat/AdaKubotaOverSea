IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TCNTDocHDDisTmp]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[TCNTDocHDDisTmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTXthDocNo] [varchar](20) NOT NULL,
	[FDXtdDateIns] [datetime] NOT NULL,
	[FTXtdDisChgTxt] [varchar](20) NULL,
	[FTXtdDisChgType] [varchar](10) NULL,
	[FCXtdTotalAfDisChg] [numeric](18, 4) NULL,
	[FCXtdTotalB4DisChg] [numeric](18, 4) NULL,
	[FCXtdDisChg] [numeric](18, 4) NULL,
	[FCXtdAmt] [numeric](18, 4) NULL,
	[FTSessionID] [varchar](255) NULL,
	[FDLastUpdOn] [datetime] NULL,
	[FDCreateOn] [datetime] NULL,
	[FTLastUpdBy] [varchar](255) NULL,
	[FTCreateBy] [varchar](255) NULL,
 CONSTRAINT [PK_TCNTDocHDDisTmp] PRIMARY KEY CLUSTERED 
(
	[FTBchCode] ASC,
	[FTXthDocNo] ASC,
	[FDXtdDateIns] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END