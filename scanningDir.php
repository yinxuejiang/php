<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文件夹列表</title>
<meta name="Keywords" content="$SiteKeywords" />
<meta name="Description" content="$SiteDescription " />
<meta name="renderer" content="webkit">
<style type="text/css">
	ol { padding: 30px; margin: 0 20px;}
	ol li{ list-style: decimal-leading-zero; padding: 0px 10px;}
	ol li a{ font-size: 18px; color: #000; line-height: 30px; text-decoration: underline; }
	ol li a:hover{ color: blue; text-decoration: underline; }
</style>
</head>
<body>
<?php
scanningDir ( "." );
function scanningDir($dirname) {
	if (file_exists ( $dirname )) {
		$dir = opendir ( $dirname );
		echo "<ol>\r\n";
		while ( ! ! $filename = readdir ( $dir ) ) {
			if ($filename != "." && $filename != "..") {
				$file =  $filename;				
				if (is_dir ( $file ) && $file !="kod") {
					echo '<li><a href="'.yang_gbk2utf8($file).'" target="_blank">' . yang_gbk2utf8($file) . '</a></li>'."\r\n";
				}
			}
		}
		echo "</ol>\r\n";
		closedir ( $dir );		
	}
}
/** 
*自动判断把gbk或gb2312编码的字符串转为utf8 
*能自动判断输入字符串的编码类，如果本身是utf-8就不用转换，否则就转换为utf-8的字符串 
*支持的字符编码类型是：utf-8,gbk,gb2312 
*@$str:string 字符串 
*/ 
function yang_gbk2utf8($str){ 
    $charset = mb_detect_encoding($str,array('UTF-8','GBK','GB2312')); 
    $charset = strtolower($charset); 
    if('cp936' == $charset){ 
        $charset='GBK'; 
    } 
    if("utf-8" != $charset){ 
        $str = iconv($charset,"UTF-8//IGNORE",$str); 
    } 
    return $str; 
}
?>
</body>
</html>