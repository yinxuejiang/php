<?php
header("Content-type: text/html; charset=gb2312"); 
echo "��ʼ����<br>";

$dirname="test";

copydir ( $dirname, "hello" );
/**
 * [copydir ����һ���ļ��е���һ���ļ��в����������ļ�]
 * @param  [type] $dirsrc [���������ļ���]
 * @param  [type] $dirto  [����һ���ļ���]
 * @return [type] Ŀ¼    [һ�����ļ���]
 */
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
						
			if (is_dir ( $file1 )) {
				$file2 = $dirto . "/" .$filename;
				copydir ( $file1, $file2 ); // �ݹ鴦��
			} else {
				$file2 = $dirto . "/" . renameFn ( $filename );
				copy ( $file1, $file2 );
				echo $file2."�����ļ��ɹ�"."<br>";
			}
		}
	}
	closedir ( $dir );
}

function pregReplaceName($matches) {	
	$str = '�ٶ�';
	return $str.$matches[1].".lrc";
}

function renameFn( $file ){
	$pattern = "/([0-9]+).*/";
	$baname =  preg_replace_callback($pattern, "pregReplaceName", $file);
	return $baname;
}
?>
