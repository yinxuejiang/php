<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>html列表</title>
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
scanningHtml ( "./" );
/**
 * [scanningHtml 查找出一个目录下的所有html文件]
 * @param  [type] $dirname [目录文件]
 * @return [type]  列表    [所有html名字的列表]
 */
function scanningHtml($dirname) {
	if (file_exists ( $dirname )) {
		$dir = opendir ( $dirname );
		echo "<ol>\r\n";
		while ( ! ! $filename = readdir ( $dir ) ) {
			if ($filename != "." && $filename != "..") {
				$file =  $filename;				
				if (is_file ( $file ) && (stristr($file,".") == ".html" || stristr($file,".") == ".htm")) {
					echo '<li><a href="'.yang_gbk2utf8($file).'" target="_blank">' . yang_gbk2utf8($file) . '</a></li>'."\r\n";
				}
			}
		}
		echo "</ol>\r\n";
		closedir ( $dir );		
	}
}

/** 
 * 自动判断把gbk或gb2312编码的字符串转为utf8 
 * 能自动判断输入字符串的编码类，如果本身是utf-8就不用转换，否则就转换为utf-8的字符串 
 * 支持的字符编码类型是：utf-8,gbk,gb2312 
 * @$str:string 字符串 
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