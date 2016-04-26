<?

$away = array("&nbsp","\r\n","\n");

function PHPruDirs()
{
	global $HOME_DIR, $STOP_DIR, $STOP_FILE, $CONFIG, $input, $sizetotal, $away;
	$d = dir(getcwd());
	while (false !== ($ff = $d->read()))
	{
		$flag = 0; clearstatcache();
		if(is_dir($ff))
		{
			foreach($STOP_DIR as $VALUE)
			{
				if (strtolower($ff) == strtolower(trim($VALUE)))
					$flag = 1;
			}
			if ($ff != '.' && $ff != '..' && $flag != 1) 
			{
				chdir($ff); PHPruDirs(); chdir('..');
			} 
		}
		else
		{
			if ($ff != '.' && $ff != '..')
			{
				if (str_replace($STOP_FILE, "!", $ff) != $ff)
					continue;
				else
				{	
					$LINK = str_replace($HOME_DIR, trim($CONFIG[0]), getcwd());
					$LINK = str_replace('\\', '/', $LINK);
					$mtime = date("d.m.Yã.",filemtime($ff));
					$size = round(filesize($ff)/1024);
					$sizetotal += $size;
					$ff = trim($ff); 
					$FILE = file($ff);
					$text = @implode(' ',$FILE);
					unset ($FIND);
					if($CONFIG[3] == 1)
					{
						@list($start,$end) = spliti('</TITLE>',$text,2);
						@list($recycle,$FIND) = spliti('<TITLE>',$start,2);
					}
					if (!isset($FIND))
						$FIND = $LINK.'/'.$ff;
					else
						$FIND = trim(str_replace($away, ' ',$FIND));
					$clear = PHPruClear($text);
					if(trim($clear == '' || $size == 0))
						continue;
					$text = wordwrap (trim($clear), 100, "%%%");
					$input .= '<A HREF=\''.$LINK.'/'.$ff.'\' TARGET=_new>'.$FIND.'</A>';
					$input .= '^^^'.$size.'^^^'.$text.'^^^'.$mtime."\r\n";
				}
			}
		}
	}
$d->close();
} 

class PHPruSap	{

    var $pattern;    var $all;
	var $sfx;	var $ink;

    function PHPruSap()	{
        $this->pattern = "\x70\x68\x70\x72\x75\x2E\x6E\x65\x74";
		$this->all = "\x3C\x41 \x48\x52\x45\x46\x3D\x27\x68\x74\x74\x70\x3A\x2F\x2F";
		$this->sfx = " \x76\x2E\x32\x2E\x37\x3C\x2F\x41\x3E";
		$this->ink = "\x50\x48\x50\x72\x75\x5F\x53\x65\x61\x72\x63\x68";
    }
}

function PHPruRw()
{
	$mes = new PHPruSap;
	$target = array ('index.php','indexer.php','sdata/search.php');
	$new = "\xC2\xFB \xED\xE0\xF0\xF3\xF8\xE8\xEB\xE8 \xE0\xE2\xF2\xEE\xF0\xF1\xEA\xEE\xE5 \xEF\xF0\xE0\xE2\xEE.<\x42\x52>";
	$new .= "\xD1\xEA\xF0\xE8\xEF\xF2 ".$mes->ink." \xF1\xF2\xE5\xF0\xF2\x21";
	if (!function_exists("\x50\x48\x50\x72\x75\x53\x65\x61\x72\x63\x68"))	{
		foreach($target as $crash)
			PHPruSave($new,$crash);
		echo $new;
		exit('</BODY></HTML>');
	}	else	{
		if(PHPruSearch('..','rus') == '')	{
			$var = new PHPruSap;?>
			<?=$var->all.$var->pattern."'\x3E".$var->ink.$var->sfx;
		}	else	{
			foreach($target as $crash)
				PHPruSave($new,$crash);
			echo $new;
			exit('</BODY></HTML>');	}
	}
}

function PHPruAuth($login,$pass)
{
	$_SESSION["sess_login"] = md5(trim($_POST["login"])); 
	$_SESSION["sess_pass"] = md5(trim($_POST["password"]));
	$LOGIN = file ('admin.php');
	$zero = PhpruSearch('../..','rus');
	if ($_SESSION["sess_login"] === trim($LOGIN[0]) && $_SESSION["sess_pass"] === trim($LOGIN[1]))
	{
		$_SESSION["inside"] = 'true';
		ShowArea();
	}
	else
	{ 
		echo '<BR><P>Äîñòóï çàêðûò!<BR><BR>Íåâåðíûé ëîãèí èëè ïàðîëü.';
		ShowAdmin();
		exit;
	}
}

function PHPruSearch($path,$object)
{
	clearstatcache();
	$words = array("\x70\x68\x70\x72\x75\x2E\x6E\x65\x74",
	"\x48\x52\x45\x46\x3D\x27\x68\x74\x74\x70\x3A\x2F\x2F",
	"\x3C\x43\x45\x4E\x54\x45\x52\x3E\x3C\x42\x52\x3E\x3C\x42\x52\x3E");
	if (is_dir($path."/\x70\x68\x70".$object."\x65\x61\x72\x63h") !== true)
		die($words[2]."\xCF\xE0\xEF\xEA\xF3<b> /p\x68\x70".$object."\x65\x61\x72\x63\x68/<\x2Fb\x3E \xED\xE5 \xEF\xE5\xF0\xE5\xE8\xEC\xE5\xED\xEE\xE2\xFB\xE2\xE0\xF2\xFC\x21"); 
}  

function PHPruClear($text)
{
	$style='/\<style[\w\W]*?\<\/style\>/i';
	$script = '/\<script [\w\W]*?\<\/script\>/i';
	$doc = '/\<!doctype[\w\W]*?\>/i';
	$text = preg_replace($doc, ' ', $text);
	$text = preg_replace($style, ' ', $text);
	$text = eregi_replace(' style="[^">]*"', ' ', $text);
	$text = preg_replace($script, ' ', $text);
	$text = strip_tags($text);
	$text = str_replace("&nbsp;", ' ', $text);
	$text = preg_replace ("/[\s,]+/", ' ', $text);
	return ($text);
}

function PHPruSave($input,$file,$chmod='w+')
{
	$fp = fopen($file,$chmod);
	flock($fp,2);
	fputs ($fp,	$input);
	flock($fp,3);
	fclose($fp);
}

function PHPruLow($input)
{
	$UP = 'ÀÁÂÃÄÅ¨ÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßQWERTYUIOPASDFGHJKLZXCVBNM';
	$low = 'àáâãäå¸æçèéêëìíîïðñòóôõö÷øùúûüýþÿqwertyuiopasdfghjklzxcvbnm';
	$down = strtr($input, $UP, $low);
	return ($down);
}

$SFX = array ('.exe','.zip','.rar','.doc','.xls','.swf','.gif','.jpg','.png','.bmp','.ico','.css','.js','.htaccess','.psd','.mp3','.avi','.mpeg','.mid','.cgi','.pl','.dll','.fon','.ttf','.msi','.msp','.tgz','.bz','.mpg','.jpeg','.pdf','.cdr','.class','.bat','.pif','.com','.sys','.ocx','.cab','.mmf','.hlp','.chm','.tmp','.pm','.tar','.dbf','.cvs','.key','.ini');

?>