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
?>
<TABLE BORDER=0 WIDTH=95%>
<TR><TD>
�� ������: <B>
<?
require ('sinc/func_list.php');
$CONFIG = file('sinc/sconfig.php'); // ���� ������������

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
<BR>������� ����������� ������� � ������ ������� - ( <FONT COLOR=BLUE><?=htmlspecialchars($error_1[0])?></FONT> )
<BR><BR>
</TD></TR>
</TABLE>
<?
	exit;
}
if (strlen(trim($_POST["query"])) < 3)
{
?>
<BR>������� �������� ������� �� ��������������. ����������� �� ����� 3 ��������.
<BR><BR>
</TD></TR>
</TABLE>
<?
	exit;
}
$searchstring = PHPruLow(trim($_POST["query"]));
$searchword = explode (" ",$searchstring); // ������ ������ �������
$allwords = count($searchword); // ������� ���� � �������

##################################################################

$FILE = file('sdata/search.php');
$count = count($FILE);
PHPruSearch('..','rus');
for ($x = 0; $x < $count; $x++) // �������� ����
{
	@list($filename,$filesize,$content,$modify) = explode('^^^',$FILE[$x],4);
	$temp = explode('%%%',$content);
	$true = $find = $full_result = $long = 0;
	$sizetotal += $filesize;
		
	foreach($temp as $key => $value) // �������� ������
	{
		if($allwords > 1) // ���� ����� ������ ����� � �������
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
		for ($all = 0; $all < $allwords; $all++) // �������� �� ������� �� ���� � �������
		{	
			$chekfull = explode(" ",$value);
			if(in_array($searchword[$all],$chekfull))
				$full_result++;	
			
			$long = strlen($searchword[$all]);
			if ($long > 5)
			{
			if(preg_match("/(�|�|�|�|�|�|�|�)$/i", $searchword[$all]))
				$long = -1;
			if(preg_match("/(�|�|�|�|�|�)[��������]$/i", $searchword[$all]))
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
		echo '<BR><BR><B>'.$filename.'</B><BR><I>���� ���������� ���������� ��������� - '.$modify.', ����e� - '.$filesize.'Kb</I><BR> ������� '.$find.' ���������� ( ������ - '.$full_result.', ������� - '.($find-$full_result).')<BR>����� ��� ����� ���:';
		
		if ($find > trim($CONFIG[1])) // ����������� ���������� ��������� �����
			$STROK = trim($CONFIG[1]);
		else
			$STROK = $find;
		for ($a = 1; $a < $STROK+1; $a++) // ������� ���������� ���������
		{
			echo '<LI>...'.$show[$a].'...</LI>';
		}
	}
}

if(!isset($fulltrue))
	echo '<BR>� ���������, �� ������ ������� ������ �� �������!';

echo '<BR><BR><CENTER>����� ���������� '.$sizetotal.'Kb � '.$count.' ������ �� ';
$microtime = microtime();
$microsecs = substr($microtime, 2, 8);
$secs = substr($microtime, 11);
$end_time = "$secs.$microsecs";
$total = round(($end_time - $start_time),2);
echo $total.' ���. <BR><BR>';
PHPruRw(); flush();
if (isset($_SERVER["REMOTE_ADDR"]))
	$IP = $_SERVER["REMOTE_ADDR"];
else
	$IP = '��� ������';
$NEW = time().'^^'.$searchstring.'^^'.$_SERVER["HTTP_REFERER"].'^^'.$IP."\r\n";
PHPruSave($NEW,'sinc/query.php','a+');
}
else
	echo '������ �� ����� �� ��������!<BR><BR><CENTER>';
?>
<BR>
</TD></TR>
</TABLE>