<?php
header("Content-type: text/html; charset=gb2312"); 
echo "��ʼ����<br>";

$dirname="folder";

copydir ( $dirname, "hello" );


function copydir($dirsrc, $dirto) {
	if (! is_dir ( $dirsrc )) {
		echo "Ŀ�겻��Ŀ¼���ܸ���";
		return;
	}
		
	if (! file_exists ( $dirto )) {
		mkdir ( $dirto );
		echo "����Ŀ¼".$dirto."�ɹ���<br>";
	}else{
		echo "Ŀ���Ѵ��ڣ����ܴ���";
		return;
	}
	
	$dir = opendir ( $dirsrc );
	
	while ( ! ! $filename = readdir ( $dir ) ) {
		if ($filename != "." && $filename != "..") {
			$file1 = $dirsrc . "/" . $filename;
			$file2 = $dirto . "/" . $filename;
			
			if (is_dir ( $file1 )) {
				copydir ( $file1, $file2 ); // �ݹ鴦��
			} else {
				copy ( $file1, $file2 );
				echo "�����ļ��ɹ�";
			}
		}
	}
	closedir ( $dir );
}

	


?>