<?php
header("Content-type: text/html; charset=gb2312"); 
echo "开始测试<br>";

$dirname="folder";

copydir ( $dirname, "hello" );


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
			$file2 = $dirto . "/" . $filename;
			
			if (is_dir ( $file1 )) {
				copydir ( $file1, $file2 ); // 递归处理
			} else {
				copy ( $file1, $file2 );
				echo "创建文件成功";
			}
		}
	}
	closedir ( $dir );
}

	


?>