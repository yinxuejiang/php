<?php
header("Content-type: text/html; charset=gb2312"); 
echo "开始测试<br>";

$dirname="phpMyAdmin";

deldir ( $dirname );

/**
 * [deldir 删除目录]
 * @param  [type] $dirname [被删除的目录]
 * @return [type]          [空]
 */
function deldir($dirname) {
	if (file_exists ( $dirname )) {
		$dir = opendir ( $dirname );
		while (!! $filename = readdir ( $dir ) ) {
			if ($filename != "." && $filename != "..") {
				$file = $dirname . "/" . $filename;
				
				if (is_dir ( $file )) {
					
					deldir ( $file ); // 使用递归删除子目录
				} else {
					echo '删除文件<b>' . $file . '</b>成功<br>';
					unlink ( $file );
				}
			}
		}
		closedir ( $dir );
		echo '删除目录<b>' . $dirname . '</b>成功<br>';
		rmdir ( $dirname );
	}
}
	


?>