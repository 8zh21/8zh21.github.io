<?
session_name("ADMIN_SESS");
session_start();
require ('../sinc/func_list.php');
?>
<HTML>
<HEAD>
<TITLE>����������������� PHPru_Search v.2.7</TITLE>
<LINK href="/phprusearch/sinc/phpru.css" type=text/css rel=stylesheet>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</HEAD>
<BODY>
<CENTER>
<?
if ($_SERVER["QUERY_STRING"] == 'faq')
	$SIZER = 'scrollbars=yes,width=500,height=350';
else
	$SIZER = 'scrollbars=no,width=400,height=300';
?>
<script language="javascript1.1">
function popup(eventurl) {
winStats='toolbar=no,location=no,directories=no,menubar=no,'
winStats+='<?=$SIZER?>'
if (navigator.appName.indexOf("Microsoft")>=0) {
	winStats+=',left=1,top=1'
	}else{
	winStats+=',screenX=1,screenY=1'
	}
eventwindow=window.open(eventurl,"",winStats).focus()     
}
</script>
<?

if(isset($_SESSION["inside"]) && $_SESSION["inside"] == 'true' && !isset($_POST["admin"]))
{
	ShowArea();
}

if (isset($_POST["save"]) && isset($_SESSION["inside"]))
{
	$INPUT = array();
	$INPUT[0] = $_POST["domen"];
	$INPUT[1] = $_POST["num"];
	$INPUT[2] = $_POST["color"];
	if ($_POST["title"][0] == 0) 
		$INPUT[3] = 0;
	else
		$INPUT[3] = 1;
	$INPUT[4] = $_POST["dirs"];
	$INPUT[5] = $_POST["files"];
	$INPUT[6] = $_POST["style"];
	$INPUT[7] = str_replace("<","</",$_POST["style"]);
	$NEW = implode ("\r\n",$INPUT) ;

	PHPruSave($NEW,'../sinc/sconfig.php');

	echo '<CENTER><BR><BR><BR><B>��������� �������!</B><BR>';
	exit(require('../sinc/footer.php'));
}
elseif (isset($_POST["save_new"]) && isset($_SESSION["inside"]))
{
	$NEW = md5(trim($_POST["new_login"]))."\r\n".md5(trim($_POST["new_pass"]));
	PHPruSave($NEW,'admin.php');
	session_destroy();
	session_unset();
	unset($_SESSION,$_GET,$_POST);
?>
<!-- ����� ������ �������� �� ���� -->
<script language="JavaScript">window.location="index.php"</script>
<?
	exit;
}
if ($_SERVER["QUERY_STRING"] == 'change' && isset($_SESSION["inside"]) && PhpruSearch('../..','rus') == '')
{
?>
<FORM METHOD=POST ACTION="">
<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444>
<TBODY BGCOLOR=IVORY>
<TR>
	<TD COLSPAN=2>
	��������� ������ � ������...<BR><BR>
	<FONT COLOR="RED">������ ����� �����������. ������ ��������� ���������� md5.<BR>
	��� ������, ��� � ��� � ����-���� ������� �� ����� ������� � ���������� ������������� ��������� ������!</FONT><BR><BR>
	</TD>
</TR>
<TR>
	<TD ALIGN=RIGHT>����� Login: </TD>
	<TD><INPUT TYPE="text" NAME="new_login" VALUE=""></TD>
</TR><TR>
	<TD ALIGN=RIGHT>����� Password: </TD>
	<TD><INPUT TYPE="text" NAME="new_pass" VALUE=""></TD>
</TR><TR>
	<TD></TD><TD><INPUT TYPE="submit" NAME="save_new" VALUE="��������"></TD>
</TR>
</TBODY>
</TABLE>
</FORM>
<?	
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'config' && isset($_SESSION["inside"]))
{
	$FILE = file('../sinc/sconfig.php');
	if ($FILE[3] == 0)
		{$type[0] = 'checked';$type[1] = '';}
	else
		{$type[1] = 'checked';$type[0] = '';}
?>
<FORM NAME="phpru" METHOD=POST ACTION="">
<TABLE WIDTH=95% BORDER=0 CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444>
<TBODY BGCOLOR=IVORY>
<TR>
	<TD COLSPAN=2>���������������� ���������� ������...</TD>
</TR><TR>
	<TD ALIGN=RIGHT>����� ������ �����: </TD>
	<TD><INPUT TYPE="text" SIZE=30 NAME="domen" VALUE="<?=$FILE[0]?>"></TD>
</TR><TR>
	<TD ALIGN=RIGHT>����� � ������������: </TD>
	<TD><INPUT TYPE="text" NAME="num" VALUE="<?=trim($FILE[1])?>" SIZE=1><FONT COLOR=#999999> - ���������� ��������� ����� � ������������</TD>
</TR><TR>
	<TD ALIGN=RIGHT>���� ��������� ����������: </TD>
	<TD>

<SCRIPT LANGUAGE="JavaScript">
<!--
var hex = new Array(6)

hex[0] = "FF"
hex[1] = "CC"
hex[2] = "99"
hex[3] = "66"
hex[4] = "33"
hex[5] = "00"

function display(triplet) {
	window.document.phpru.color.value = '#' + triplet
	Help(triplet)
}

function drawCell(red, green, blue) {
	document.write('<TD style="PADDING:0;" BGCOLOR="#' + red + green + blue + '">')
	document.write('<A HREF="javascript:display(\'' + (red + green + blue) + '\')">')
	document.write('<IMG SRC="place.gif" BORDER=0 HEIGHT=12 WIDTH=12>')
	document.write('</A>')
	document.write('</TD>')
}

function drawRow(red, blue) {
	document.write('<TR>')
	for (var i = 0; i < 6; ++i) {
		drawCell(red, hex[i], blue)
	}
	document.write('</TR>')
}

function drawTable(blue) {
	document.write('<TABLE CELLPADDING=0 CELLSPACING=0 BORDER=0>')
	for (var i = 0; i < 6; ++i) {
		drawRow(hex[i], blue)
	}
	document.write('</TABLE>')	
}

function drawCube() {
	document.write('<TABLE CELLPADDING=5 CELLSPACING=0 BORDER=0><TR>')
	for (var i = 0; i < 6; ++i) {
		document.write('<TD BGCOLOR="#FFFFFF" style="PADDING:0;">')
		drawTable(hex[i])
		document.write('</TD>')
	}
	document.write('</TR></TABLE>')
}

function Help(id){
	msg = '<FONT COLOR='+id+'><B>'+id+'</B></FONT><BR>'
	document.all.text.innerHTML = msg
}

function Check(i)	{
	window.document.phpru.style.value += i
}

drawCube()

// -->
</SCRIPT>
<INPUT TYPE="hidden" NAME="color" VALUE=""><BR>
������� ����: <SPAN ID=text><B><FONT COLOR="<?=trim($FILE[2])?>"><?=trim($FILE[2])?></FONT></B></SPAN>
<?PhpruSearch('../..','rus')?>
	</TD>
</TR><TR>
	<TD ALIGN=RIGHT>����� ��������� ����������: </TD>
	<TD>
	<INPUT TYPE="BUTTON" NAME="" VALUE="B" TITLE="������ �����" style="WIDTH:30px;HEIGHT:20px;" onclick="Check('<B>')">&nbsp;
	<INPUT TYPE="BUTTON" NAME="" VALUE="I" TITLE="��������� �����" style="WIDTH:30px;HEIGHT:20px;" onclick="Check('<I>')">&nbsp;
	<INPUT TYPE="BUTTON" NAME="" VALUE="U" TITLE="������������ �����" style="WIDTH:30px;HEIGHT:20px;" onclick="Check('<U>')">&nbsp;
	<INPUT TYPE="BUTTON" NAME="" VALUE="STRONG" TITLE="���������� �����" style="WIDTH:70px;HEIGHT:20px;" onclick="Check('<STRONG>')">&nbsp;
	<INPUT TYPE="text" NAME="style" VALUE="<?=trim(htmlspecialchars($FILE[6]))?>"><BR><FONT COLOR=#999999> - ���� &lt;B>, &lt;I>, � �.�.</TD>
</TR><TR>
	<TD ALIGN=RIGHT ROWSPAN=2>��� ���������� � �����������: </TD>
	<TD><INPUT TYPE="radio" VALUE=0 NAME="title[]" <?=$type[0]?>> - �������� ��� ����� <BR><FONT COLOR=#999999>��������: <?='http://'.$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]?></TD>
</TR><TR>
	<TD><INPUT TYPE="radio" VALUE=1 NAME="title[]" <?=$type[1]?>> - �������� �� ���� &lt;TITLE><BR><FONT COLOR=#999999>��������: 
<?
$text = implode(' ',file('index.php'));
@list($start,$end) = spliti('</TITLE>',$text,2);
@list($recycle,$FIND) = spliti('<TITLE>',$start,2);	
echo $FIND;
?>
	</TD>
</TR><TR>
	<TD colspan=2>����������� ����� � ���� ������: <FONT COLOR=#999999>- ������ �������� �/� ������� ��� �����</TD>
</TR><TR>
	<TD colspan=2><INPUT TYPE="text" NAME="dirs" SIZE=75 VALUE="<?=trim($FILE[4]);?>"></TD>
</TR><TR>
	<TD colspan=2>��-��������� �� ������������� ������������ ����� � ��������� ������:<BR>
	<TABLE WIDTH=500 CELLPADDING=1>
<?
$td = 0;
sort($SFX);
foreach($SFX as $value)
{
	$td++;
	if($td == 1)
		echo '<TR><TD>'.$value.'</TD>';
	elseif($td == 7)
	{
		echo '<TD>'.$value.'</TD></TR>';
		$td = 0;
	}
	else
		echo '<TD>'.$value.'</TD>';
}

?>
	</TABLE>
	</TD>
</TR><TR>
	<TD colspan=2>�� ������ ������������� ������������� ����� � ������ ������:<BR> <FONT COLOR=#999999>���������� �������� �����, ��� ����� ���� *.����������, ��� �/� �������</TD>
</TR><TR>
	<TD colspan=2><INPUT TYPE="text" NAME="files" SIZE=75 VALUE="<?=trim($FILE[5])?>"></TD>
</TR><TR>
	<TD colspan=2><INPUT TYPE="submit" NAME="save" VALUE="��������"></TD>
</TR>
</TABLE>
</FORM>
<?
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'indexer' && isset($_SESSION["inside"]))
{
?>
���� � ������� ���������������� ������� (����� 30���.) ���� ���������� �������� ������, ��� ����� ��������� ����� ��������� 404 ������, ������ ������ �� �������� ���������� ��� ����. ��� ������, ��� � ��� �� ������� ������� �� ������. � ������ ������, �������� ����� ������ ������������ ��������� ����� �������� ��� ������ �������� ��� ������ ����� � ����������. 
<script language="JavaScript">popup('../indexer.php');</script>
<?
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'search' && isset($_SESSION["inside"]))
{
?>
�� �������� ������� ����� ����������� ������ � ����� ����� ������ �����.
<BR><BR> 
��� ����� ���������� �������� ��� �� ����� /phprusearch/index.php � ����� ����� �������� � ��������� � ��� ����-�� ������ ( index.php � ����� /phprusearch/ )<BR><BR><BR><BR><CENTER>
<FORM METHOD=POST ACTION="/phprusearch/" TARGET=_new>
<B>�����</B>&nbsp;&nbsp;
<input type="text" name="query" size="20" maxlength=20 value="" style="{border: inset 1px; background: #EEEEEE;}">
<input type=submit value=" Ok " style="cursor:pointer;" class=but>
</FORM>
<?
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'query' && isset($_SESSION["inside"]))
{
	echo '��������� ������� �� �����...<BR><BR>';
	$QUERY = array_reverse(file ('../sinc/query.php'));
	echo '<TABLE WIDTH=95% CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444><TBODY BGCOLOR=IVORY><TR ALIGN=CENTER><TD><B>����</B></TD><TD><B>������</B></TD><TD><B>� ����� ��������</B></TD><TD><B>IP - ����������</B></TD></TR>';
	foreach($QUERY as $VALUE)
	{
		list($TIME,$SEARCH,$REFER,$IP) = explode("^^",$VALUE,4);
		echo '<TR ALIGN=CENTER><TD>'.date("d.m.Y�.",$TIME).'</TD>';
		echo '<TD>'.$SEARCH.'</TD>';
		echo '<TD>'.$REFER.'</TD>';
		echo '<TD>'.$IP.'</TD></TR>';
	}
	echo '</TBODY></TABLE><BR><CENTER>';
	echo '<A HREF=?clear>�������� ���� ��������</A><BR><BR>';
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'faq' && isset($_SESSION["inside"]))
{
	include('../sinc/faq.php');
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'clear' && isset($_SESSION["inside"]))
{
	$CL = fopen('../sinc/query.php',"w");
	fclose($CL);
	echo '<CENTER><BR><BR><BR><B>���� �������� - �������!</B><BR><BR>';
	exit(require('../sinc/footer.php'));
}


/* �����, ����������� ������ � ����������*/
if ($_SERVER["QUERY_STRING"] == 'out')
	{
		session_destroy();
		session_unset();
		unset($_SESSION);
		$FILE = file ('../sinc/sconfig.dat');
?>
<!-- ����� ������ �������� �� ������� �������� -->
<script language="JavaScript">window.location="<?=trim($FILE[0])?>"</script>
<?
		exit;
	}

if (isset($_POST["admin"]))
{
	PHPruAuth($_POST["login"],$_POST["password"]); 
}
else
	ShowAdmin();

/* ----------------------------------------------------------------------------- */

function ShowAdmin()
{
?>
<CENTER><BR>
<FORM METHOD=POST ACTION="">
<P><B>���� ��� ��������������:</B><BR><BR>
����� <INPUT TYPE='TEXT' SIZE=11 MAXLENGTH=12 NAME='login'>
&nbsp;������ <INPUT TYPE='PASSWORD' SIZE=11 MAXLENGTH=12 NAME='password'> &nbsp;
<INPUT TYPE='submit' NAME='admin' VALUE='Ok' class=but  
style="width:24px;cursor:hand;" onmouseover="this.style.backgroundColor='LIGHTYELLOW';" onmouseout="this.style.backgroundColor='transparent';">
</FORM><BR>
</BODY>
</HTML>
<?
}

/* ----------------------------------------------------------------------------- */

function ShowArea()
{?>
<CENTER><P>
����� ����������!<BR>
�� ���������� � ������ ���������� ��������� �������� <A HREF="http://phpru.net/scripts/">PHPru_Search v.2.7</A><BR><BR>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444>
<TBODY BGCOLOR=IVORY>
<TR VALIGN=TOP>
	<TD WIDTH=150>
		<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444>
		<TBODY BGCOLOR=IVORY>
		<TR>
			<TD>����:</TD>
		</TR><TR>
			<TD><A HREF="?change" TITLE='�������� ������'>����� ������</A></TD>
		</TR><TR>
			<TD><A HREF="?config" TITLE='��������� ���� ������������ ������'>���������</A></TD>
		</TR><TR>
			<TD><A HREF="?indexer" TITLE='���������������� ���� ��� ������'>����������</A></TD>
		</TR><TR>
			<TD><A HREF="?search" TITLE='��������� ������ ����������'>��������� �����</A></TD>
		</TR><TR>
			<TD><A HREF="?query" TITLE='����������� ����������� ������� �� �����'>�������</A></TD>
		</TR><TR>
			<TD><A HREF="?faq" TITLE='����� ���������� �������'>FAQ</A></TD>
		</TR><TR>
			<TD><A HREF="?out" TITLE='�����'>�����</A></TD>
		</TR>
		</TBODY>
		</TABLE>
	</TD>
	<TD>
<?
	if ($_SERVER["QUERY_STRING"] == '')
	{
	?>
	PHPru_Search.<BR><BR>
	<LI>������ ���� ���������� ������ � ������ ��������� ������� �� �������. 
	<LI>���� �� ����������� �����-���� CMS (������� ���������� ������), ���-�� PHP-Nuke, Post-Nuke � �.�., - �� ���� ������ ��� �� ��� ���, ��� ��� ��� ��� ������ ���������� � ����� ������.
	<LI>������ �� ������������ �������� ����� � ���� (�� ���� ����� c �������������� SSI .shtml, ��� �������� ��������� PHP require, include...)
	<LI>���� �� �� ������, ����� ��������� ����� � �����-�� ������������ ������ ��� ������, �� ������ ������������� �� � ����������.
	<LI>������ ������������ ����� ������� ������� �� 10Mb +-3Mb ( � ����������� �� ����������� ����� � ��������� ��������� �������). ��� ����������� ������� �� � ����� ��������, � �� ������������ ����������� php-�������������� �� ����������� ��������. 
	<?
	}
}
exit;
?>
</TD>
</TR>
</TBODY>
</TABLE>
<BR>