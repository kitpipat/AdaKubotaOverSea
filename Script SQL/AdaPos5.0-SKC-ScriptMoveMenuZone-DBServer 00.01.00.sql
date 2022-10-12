--  ย้ายเมนู โซน ไปไว้ที่ กลุ่ม ข้อมูลระบบ
UPDATE [TSysMenuList]
		SET [FTGmnCode] = 'SYS',
		 [FTMnuParent] = 'SYS',
		 [FNMnuSeq] = '3',
		 [FTMnuStaUse] = '1'
		WHERE ([FTMnuCode] = 'STO004');
		
-- เลื่อนเมนู
UPDATE [TSysMenuList] SET [FNMnuSeq] = '4' WHERE ([FTMnuCode] = 'SYS002');
UPDATE [TSysMenuList] SET [FNMnuSeq] = '5' WHERE ([FTMnuCode] = 'SYS003');
UPDATE [TSysMenuList] SET [FNMnuSeq] = '6' WHERE ([FTMnuCode] = 'SYS006');
UPDATE [TSysMenuList] SET [FNMnuSeq] = '7' WHERE ([FTMnuCode] = 'SYS005');
UPDATE [TSysMenuList] SET [FNMnuSeq] = '8' WHERE ([FTMnuCode] = 'SYS004');

