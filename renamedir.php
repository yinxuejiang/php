<?php
header("Content-type: text/html; charset=gb2312"); 
echo "开始测试<br>";

$dirname="test";

copydir ( $dirname, "hello" );
/**
 * [copydir 拷贝一个文件夹到另一个文件夹并重新命名文件]
 * @param  [type] $dirsrc [被拷贝的文件夹]
 * @param  [type] $dirto  [到的一个文件夹]
 * @return [type] 目录    [一个新文件夹]
 */
function copydir($dirsrc, $dirto) {
	if (! is_dir ( $dirsrc )) {
		echo "目标不是目录不能复制";
		return;
	}
		
	if (! file_exists ( $dirto )) {
		mkdir ( $dirto );
		echo "创建目录".$dirto."成功！<br>";
	}else{
		echo "目标已存在！不能创建";
		return;
	}
	
	$dir = opendir ( $dirsrc );
	
	while ( ! ! $filename = readdir ( $dir ) ) {
		if ($filename != "." && $filename != "..") {

			$file1 = $dirsrc . "/" . $filename;
						
			if (is_dir ( $file1 )) {
				$file2 = $dirto . "/" .$filename;
				copydir ( $file1, $file2 ); // 递归处理
			} else {
				$file2 = $dirto . "/" . renameFn ( $filename );
				copy ( $file1, $file2 );
				echo $file2."创建文件成功"."<br>";
			}
		}
	}
	closedir ( $dir );
}

function pregReplaceName($matches) {	
	$str = '百度';
	return $str.$matches[1].".lrc";
}

function renameFn( $file ){
	$pattern = "/([0-9]+).*/";
	$baname =  preg_replace_callback($pattern, "pregReplaceName", $file);
	return $baname;
}
?>
