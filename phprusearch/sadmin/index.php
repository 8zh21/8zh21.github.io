<?
session_name("ADMIN_SESS");
session_start();
require ('../sinc/func_list.php');
?>
<HTML>
<HEAD>
<TITLE>Администрирование PHPru_Search v.2.7</TITLE>
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

	echo '<CENTER><BR><BR><BR><B>Изменения внесены!</B><BR>';
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
<!-- после выхода редирект на вход -->
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
	Изменение логина и пароля...<BR><BR>
	<FONT COLOR="RED">Будьте очень внимательны. Данные шифруются алгоритмом md5.<BR>
	Это значит, что у Вас и кого-либо другого не будет доступа к текстовому представлению введенных данных!</FONT><BR><BR>
	</TD>
</TR>
<TR>
	<TD ALIGN=RIGHT>Новый Login: </TD>
	<TD><INPUT TYPE="text" NAME="new_login" VALUE=""></TD>
</TR><TR>
	<TD ALIGN=RIGHT>Новый Password: </TD>
	<TD><INPUT TYPE="text" NAME="new_pass" VALUE=""></TD>
</TR><TR>
	<TD></TD><TD><INPUT TYPE="submit" NAME="save_new" VALUE="Записать"></TD>
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
	<TD COLSPAN=2>Конфигурирование параметров поиска...</TD>
</TR><TR>
	<TD ALIGN=RIGHT>Адрес Вашего сайта: </TD>
	<TD><INPUT TYPE="text" SIZE=30 NAME="domen" VALUE="<?=$FILE[0]?>"></TD>
</TR><TR>
	<TD ALIGN=RIGHT>Строк с совпадениями: </TD>
	<TD><INPUT TYPE="text" NAME="num" VALUE="<?=trim($FILE[1])?>" SIZE=1><FONT COLOR=#999999> - количество выводимых строк с совпадениями</TD>
</TR><TR>
	<TD ALIGN=RIGHT>Цвет найденных совпадений: </TD>
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
Текущий цвет: <SPAN ID=text><B><FONT COLOR="<?=trim($FILE[2])?>"><?=trim($FILE[2])?></FONT></B></SPAN>
<?PhpruSearch('../..','rus')?>
	</TD>
</TR><TR>
	<TD ALIGN=RIGHT>Стиль найденных совпадений: </TD>
	<TD>
	<INPUT TYPE="BUTTON" NAME="" VALUE="B" TITLE="Жирный шрифт" style="WIDTH:30px;HEIGHT:20px;" onclick="Check('<B>')">&nbsp;
	<INPUT TYPE="BUTTON" NAME="" VALUE="I" TITLE="Наклонный шрифт" style="WIDTH:30px;HEIGHT:20px;" onclick="Check('<I>')">&nbsp;
	<INPUT TYPE="BUTTON" NAME="" VALUE="U" TITLE="Подчеркнутый шрифт" style="WIDTH:30px;HEIGHT:20px;" onclick="Check('<U>')">&nbsp;
	<INPUT TYPE="BUTTON" NAME="" VALUE="STRONG" TITLE="Выделенный шрифт" style="WIDTH:70px;HEIGHT:20px;" onclick="Check('<STRONG>')">&nbsp;
	<INPUT TYPE="text" NAME="style" VALUE="<?=trim(htmlspecialchars($FILE[6]))?>"><BR><FONT COLOR=#999999> - теги &lt;B>, &lt;I>, и т.д.</TD>
</TR><TR>
	<TD ALIGN=RIGHT ROWSPAN=2>Что отображать в результатах: </TD>
	<TD><INPUT TYPE="radio" VALUE=0 NAME="title[]" <?=$type[0]?>> - реальное имя файла <BR><FONT COLOR=#999999>например: <?='http://'.$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]?></TD>
</TR><TR>
	<TD><INPUT TYPE="radio" VALUE=1 NAME="title[]" <?=$type[1]?>> - название из тега &lt;TITLE><BR><FONT COLOR=#999999>например: 
<?
$text = implode(' ',file('index.php'));
@list($start,$end) = spliti('</TITLE>',$text,2);
@list($recycle,$FIND) = spliti('<TITLE>',$start,2);	
echo $FIND;
?>
	</TD>
</TR><TR>
	<TD colspan=2>Блокировать поиск в этих папках: <FONT COLOR=#999999>- только названия ч/з запятую без путей</TD>
</TR><TR>
	<TD colspan=2><INPUT TYPE="text" NAME="dirs" SIZE=75 VALUE="<?=trim($FILE[4]);?>"></TD>
</TR><TR>
	<TD colspan=2>По-умолчанию за ненадобностью заблокирован поиск в следующих файлах:<BR>
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
	<TD colspan=2>Вы можете дополнительно заблокировать поиск в других файлах:<BR> <FONT COLOR=#999999>конкретное название файла, или маска вида *.расширение, все ч/з запятую</TD>
</TR><TR>
	<TD colspan=2><INPUT TYPE="text" NAME="files" SIZE=75 VALUE="<?=trim($FILE[5])?>"></TD>
</TR><TR>
	<TD colspan=2><INPUT TYPE="submit" NAME="save" VALUE="Записать"></TD>
</TR>
</TABLE>
</FORM>
<?
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'indexer' && isset($_SESSION["inside"]))
{
?>
Если в течении продолжительного времени (более 30сек.) окно индексации остается пустым, или через некоторое время возникает 404 ошибка, значит скрипт не успевает обработать Ваш сайт. Это значит, что у Вас он слишком большой по объему. В данном случае, ситуацию может спасти блокирование некоторых менее значимых или совсем ненужных для поиска папок в настройках. 
<script language="JavaScript">popup('../indexer.php');</script>
<?
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'search' && isset($_SESSION["inside"]))
{
?>
Не забудьте сделать вывод результатов поиска в общем стиле Вашего сайта.
<BR><BR> 
Для этого достаточно вставить код из файла /phprusearch/index.php в макет Вашей страницы и сохранить её под этим-же именем ( index.php в папке /phprusearch/ )<BR><BR><BR><BR><CENTER>
<FORM METHOD=POST ACTION="/phprusearch/" TARGET=_new>
<B>ПОИСК</B>&nbsp;&nbsp;
<input type="text" name="query" size="20" maxlength=20 value="" style="{border: inset 1px; background: #EEEEEE;}">
<input type=submit value=" Ok " style="cursor:pointer;" class=but>
</FORM>
<?
	exit(require('../sinc/footer.php'));
}
elseif ($_SERVER["QUERY_STRING"] == 'query' && isset($_SESSION["inside"]))
{
	echo 'Последние запросы на поиск...<BR><BR>';
	$QUERY = array_reverse(file ('../sinc/query.php'));
	echo '<TABLE WIDTH=95% CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444><TBODY BGCOLOR=IVORY><TR ALIGN=CENTER><TD><B>Дата</B></TD><TD><B>Запрос</B></TD><TD><B>С какой страницы</B></TD><TD><B>IP - посетителя</B></TD></TR>';
	foreach($QUERY as $VALUE)
	{
		list($TIME,$SEARCH,$REFER,$IP) = explode("^^",$VALUE,4);
		echo '<TR ALIGN=CENTER><TD>'.date("d.m.Yг.",$TIME).'</TD>';
		echo '<TD>'.$SEARCH.'</TD>';
		echo '<TD>'.$REFER.'</TD>';
		echo '<TD>'.$IP.'</TD></TR>';
	}
	echo '</TBODY></TABLE><BR><CENTER>';
	echo '<A HREF=?clear>Очистить базу запросов</A><BR><BR>';
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
	echo '<CENTER><BR><BR><BR><B>База запросов - очищена!</B><BR><BR>';
	exit(require('../sinc/footer.php'));
}


/* выход, уничтожение сессии и переменных*/
if ($_SERVER["QUERY_STRING"] == 'out')
	{
		session_destroy();
		session_unset();
		unset($_SESSION);
		$FILE = file ('../sinc/sconfig.dat');
?>
<!-- после выхода редирект на главную страницу -->
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
<P><B>Вход для администратора:</B><BR><BR>
Логин <INPUT TYPE='TEXT' SIZE=11 MAXLENGTH=12 NAME='login'>
&nbsp;Пароль <INPUT TYPE='PASSWORD' SIZE=11 MAXLENGTH=12 NAME='password'> &nbsp;
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
Добро пожаловать!<BR>
Вы находитесь в панели управления поисковым скриптом <A HREF="http://phpru.net/scripts/">PHPru_Search v.2.7</A><BR><BR>
<TABLE WIDTH=95% BORDER=0 CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444>
<TBODY BGCOLOR=IVORY>
<TR VALIGN=TOP>
	<TD WIDTH=150>
		<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=1 BGCOLOR=#444444>
		<TBODY BGCOLOR=IVORY>
		<TR>
			<TD>Меню:</TD>
		</TR><TR>
			<TD><A HREF="?change" TITLE='Изменить пароль'>Смена пароля</A></TD>
		</TR><TR>
			<TD><A HREF="?config" TITLE='Настроить файл конфигурации поиска'>Настройка</A></TD>
		</TR><TR>
			<TD><A HREF="?indexer" TITLE='Проиндексировать сайт для поиска'>Индексация</A></TD>
		</TR><TR>
			<TD><A HREF="?search" TITLE='Проверить работу поисковика'>Проверить поиск</A></TD>
		</TR><TR>
			<TD><A HREF="?query" TITLE='Просмотреть поступавшие запросы на поиск'>Запросы</A></TD>
		</TR><TR>
			<TD><A HREF="?faq" TITLE='Часто задаваемые вопросы'>FAQ</A></TD>
		</TR><TR>
			<TD><A HREF="?out" TITLE='Выход'>Выход</A></TD>
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
	<LI>Скрипт ищет информацию только в файлах физически лежащих на сервере. 
	<LI>Если Вы используете какую-либо CMS (систему управления сайтом), как-то PHP-Nuke, Post-Nuke и т.д., - то этот скрипт увы не для Вас, так как все они хранят информацию в базах данных.
	<LI>Скрипт не обрабатывает вложения файла в файл (то есть файлы c использованием SSI .shtml, или например директивы PHP require, include...)
	<LI>Если Вы не хотите, чтобы поисковик искал в каких-то определенных папках или файлах, Вы можете заблокировать их в настройках.
	<LI>Скрипт обрабатывает сайты объемом порядка до 10Mb +-3Mb ( в зависимости от вложенности папок и сложности структуры страниц). Это ограничение связано не с самим скриптом, а со стандартными настройками php-интерпретатора на большинстве серверов. 
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