<HTML>
<HEAD>
<TITLE>�������������� �����...</TITLE>
<LINK href="/phprusearch/sinc/phpru.css" type=text/css rel=stylesheet>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<CENTER>
<?

	/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	+              ��������: | PHPru_Search                          +
	+ -------------------------------------------------------------- + 
	+                ������: | 2.7                                   +
	+             ���������: | ���������� ������                     +
	+            ����������: | PHP4                                  +
	+             ���������: | �����                                 +
	+                  ����: | �������                               +
	+                 �����: | Alex (http://www.phpru.net)           +
	+   Copyright 2003-2004: | PHPru.net� - All Rights Reserved.     +
	+ -------------------------------------------------------------- + 
	+              ��������: | 25 ������ 2004                        +
	+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */ 

#######################################################################
error_reporting(0);
chdir('..');
require ('phprusearch/sinc/func_list.php');
$microtime = microtime();
$microsecs = substr($microtime, 2, 8);
$secs = substr($microtime, 11);
$start_time = "$secs.$microsecs";
$input = $sizetotal = '';
$CONFIG = file('phprusearch/sinc/sconfig.php');
$STOP_DIR = split(",",$CONFIG[4]);
$STOP_FILE = split(",",$CONFIG[5]);
$HOME_DIR = getcwd();
$STOP_FILE = array_unique(array_merge($STOP_FILE, $SFX));
PHPruDirs();
PHPruSave($input,'phprusearch/sdata/search.php');
echo '<CENTER><BR><BR><P>��������� ���� ��������.<BR><BR>������� ������ ��� ������ ������.<BR><BR>����� ���������� '.$sizetotal.'Kb �� ';
$microtime = microtime();
$microsecs = substr($microtime, 2, 8);
$secs = substr($microtime, 11);
$end_time = "$secs.$microsecs";
$total = round(($end_time - $start_time),2);
echo $total.' ���. <BR><BR>';
?>
<A HREF="http://phpru.net/scripts/">PHPru_Search v.2.7</A><BR><BR>
Copyright &copy; 2003-2004 <A HREF="http://phpru.net">PHPru.net&trade;</A>
</TD></TR>
</TABLE><BR><BR><BR><BR>
<INPUT TYPE="button" VALUE='�������' class=button onclick=window.close();>
</BODY>
</HTML>