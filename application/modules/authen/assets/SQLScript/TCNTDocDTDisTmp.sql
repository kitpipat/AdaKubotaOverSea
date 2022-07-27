IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TCNTDocDTDisTmp]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[TCNTDocDTDisTmp](
	[FTBchCode] [varchar](5) NOT NULL,
	[FTXthDocNo] [varchar](20) NOT NULL,
	[FNXtdSeqNo] [bigint] NOT NULL,
	[FTSessionID] [varchar](255) NOT NULL,
	[FDXtdDateIns] [datetime] NOT NULL,
	[FNXtdStaDis] [bigint] NULL,
	[FTXtdDisChgType] [varchar](10) NULL,
	[FCXtdNet] [numeric](18, 4) NULL,
	[FCXtdValue] [numeric](18, 4) NULL,
	[FDLastUpdOn] [datetime] NULL,
	[FDCreateOn] [datetime] NULL,
	[FTLastUpdBy] [varchar](20) NULL,
	[FTCreateBy] [varchar](20) NULL,
	[FTXtdDisChgTxt] [varchar](20) NULL,
 CONSTRAINT [PK_TCNTDocDTDisTmp] PRIMARY KEY CLUSTERED 
(
	[FTBchCode] ASC,
	[FTXthDocNo] ASC,
	[FNXtdSeqNo] ASC,
	[FTSessionID] ASC,
	[FDXtdDateIns] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
END