<?php
header("Content-type: text/html; charset=gb2312"); 
echo "��ʼ����<br>";

$dirname="phpMyAdmin";

deldir ( $dirname );

/**
 * [deldir ɾ��Ŀ¼]
 * @param  [type] $dirname [��ɾ����Ŀ¼]
 * @return [type]          [��]
 */
function deldir($dirname) {
	if (file_exists ( $dirname )) {
		$dir = opendir ( $dirname );
		while (!! $filename = readdir ( $dir ) ) {
			if ($filename != "." && $filename != "..") {
				$file = $dirname . "/" . $filename;
				
				if (is_dir ( $file )) {
					
					deldir ( $file ); // ʹ�õݹ�ɾ����Ŀ¼
				} else {
					echo 'ɾ���ļ�<b>' . $file . '</b>�ɹ�<br>';
					unlink ( $file );
				}
			}
		}
		closedir ( $dir );
		echo 'ɾ��Ŀ¼<b>' . $dirname . '</b>�ɹ�<br>';
		rmdir ( $dirname );
	}
}
	


?>