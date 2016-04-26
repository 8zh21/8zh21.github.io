<?

	/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +
	+              Название: | PHPru_Search                          +
	+ -------------------------------------------------------------- + 
	+                Версия: | 2.7                                   +
	+             Стоимость: | бесплатный скрипт                     +
	+            Требования: | PHP4                                  +
	+             Платформа: | любая                                 +
	+                  Язык: | русский                               +
	+                 Автор: | Alex (http://www.phpru.net)           +
	+   Copyright 2003-2004: | PHPru.net™ - All Rights Reserved.     +
	+ -------------------------------------------------------------- + 
	+              Обновлен: | 25 ноября 2004                        +
	+ + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */ 

#######################################################################
?>
<TABLE BORDER=0 WIDTH=95%>
<TR><TD>
Вы искали: <B>
<?
require ('sinc/func_list.php');
$CONFIG = file('sinc/sconfig.php'); // файл конфигурации

if (isset($_POST["query"]))
{
echo htmlspecialchars(trim($_POST["query"])).'</B></CENTER>';
$microtime = microtime();
$microsecs = substr($microtime, 2, 8);
$secs = substr($microtime, 11);
$start_time = "$secs.$microsecs";
$sizetotal = 0;

if ( ereg ( "[><?]+", $_POST["query"], $error_1 ))
{
?>
<BR>Найдены запрещенные символы в строке запроса - ( <FONT COLOR=BLUE><?=htmlspecialchars($error_1[0])?></FONT> )
<BR><BR>
</TD></TR>
</TABLE>
<?
	exit;
}
if (strlen(trim($_POST["query"])) < 3)
{
?>
<BR>Слишком короткие запросы не обрабатываются. Используйте не менее 3 символов.
<BR><BR>
</TD></TR>
</TABLE>
<?
	exit;
}
$searchstring = PHPruLow(trim($_POST["query"]));
$searchword = explode (" ",$searchstring); // массив строки запроса
$allwords = count($searchword); // сколько слов в запросе

##################################################################

$FILE = file('sdata/search.php');
$count = count($FILE);
PHPruSearch('..','rus');
for ($x = 0; $x < $count; $x++) // выбираем файл
{
	@list($filename,$filesize,$content,$modify) = explode('^^^',$FILE[$x],4);
	$temp = explode('%%%',$content);
	$true = $find = $full_result = $long = 0;
	$sizetotal += $filesize;
		
	foreach($temp as $key => $value) // выбираем строку
	{
		if($allwords > 1) // если более одного слова в запросе
		{
			if(preg_match_all("/".$searchstring."/i", $value, $ok, PREG_PATTERN_ORDER))
				$new = str_replace($ok[0][0],'<FONT COLOR='.trim($CONFIG[2]).'>'.trim($CONFIG[6]).$ok[0][0].'</FONT>'.trim($CONFIG[7]), $value);
			else
				$new = $value;
			if($new != $value)
			{
				$find++;
				$true = 1;
				$show[$find] = $new;
				$full_result++; 
			}
		}
		for ($all = 0; $all < $allwords; $all++) // проходим по каждому из слов в запросе
		{	
			$chekfull = explode(" ",$value);
			if(in_array($searchword[$all],$chekfull))
				$full_result++;	
			
			$long = strlen($searchword[$all]);
			if ($long > 5)
			{
			if(preg_match("/(у|ы|а|о|я|е|и|ь)$/i", $searchword[$all]))
				$long = -1;
			if(preg_match("/(и|е|о|а|ы|у)[еямюйивх]$/i", $searchword[$all]))
				$long = -2;
			$short = substr($searchword[$all],0,$long);
			if(preg_match_all("/".$short."/i", $value, $ok, PREG_PATTERN_ORDER))
				$new = str_replace(PHPruLow($ok[0][0]),'<FONT COLOR='.trim($CONFIG[2]).'>'.trim($CONFIG[6]).$ok[0][0].'</FONT>'.trim($CONFIG[7]), PHPruLow($value));
			else
				$new = $value;

				if($new != $value)
				{
					$find++;
					$true = 1;
					$show[$find] = $new;
				}
			}
			else
			{
				$short = $searchword[$all];
				if(preg_match_all("/".$short."/i", $value, $ok, PREG_PATTERN_ORDER))
					$new = str_replace(PHPruLow($ok[0][0]),'<FONT COLOR='.trim($CONFIG[2]).'>'.trim($CONFIG[6]).$ok[0][0].'</FONT>'.trim($CONFIG[7]), PHPruLow($value));
				else
					$new = $value;
				if($new != $value)
				{
					$find++;
					$true = 1;
					$show[$find] = $new;
				}
			}
		}	
	}
	if ($true !== 0)
	{
		$fulltrue = 1;
		echo '<BR><BR><B>'.$filename.'</B><BR><I>дата последнего обновления документа - '.$modify.', размeр - '.$filesize.'Kb</I><BR> найдено '.$find.' совпадений ( точных - '.$full_result.', похожих - '.($find-$full_result).')<BR>среди них такие как:';
		
		if ($find > trim($CONFIG[1])) // ограничение количества выводимых строк
			$STROK = trim($CONFIG[1]);
		else
			$STROK = $find;
		for ($a = 1; $a < $STROK+1; $a++) // выводим совпадения построчно
		{
			echo '<LI>...'.$show[$a].'...</LI>';
		}
	}
}

if(!isset($fulltrue))
	echo '<BR>К сожалению, по Вашему запросу ничего не найдено!';

echo '<BR><BR><CENTER>всего обработано '.$sizetotal.'Kb в '.$count.' файлах за ';
$microtime = microtime();
$microsecs = substr($microtime, 2, 8);
$secs = substr($microtime, 11);
$end_time = "$secs.$microsecs";
$total = round(($end_time - $start_time),2);
echo $total.' сек. <BR><BR>';
PHPruRw(); flush();
if (isset($_SERVER["REMOTE_ADDR"]))
	$IP = $_SERVER["REMOTE_ADDR"];
else
	$IP = 'нет данных';
$NEW = time().'^^'.$searchstring.'^^'.$_SERVER["HTTP_REFERER"].'^^'.$IP."\r\n";
PHPruSave($NEW,'sinc/query.php','a+');
}
else
	echo 'Запрос на поиск не поступал!<BR><BR><CENTER>';
?>
<BR>
</TD></TR>
</TABLE>