<?php
	class extractWords {
	
	public $file;						//被提取文件
	public $isOrder = false;			//是否排序
	public $generateFileName;			//生成文件的名字
	public $wordsCounts = 0;			//生成单词的数量
	protected $fileContent;				//文字内容
	protected $newFileContent;				//新文字内容
	protected $dictionary;				//字典
	protected $myWordsFile = 'myWords.txt';			//生成我的单词
	                     
	// 构造函数
	public function __construct() {

	}
	
	// 析构函数
	public function __destruct() {

	}
	
	// ////////////////////// public方法 ////////////////////////

	/**
	 * 获取单词内容
	 */
	public function getWords(){
		$this->dictionary = file_get_contents ( "./dictionary.txt" );
		if(is_file($this->file)){
			// 读取文档
			$this->fileContent = file_get_contents ( $this->file );
		}else{
			$this->fileContent = $this->file;
		}
		// 转化成单词 用空格隔开
		$this->fileContent = $this->leaveWords ( $this->fileContent );
		// 去重单词
		$this->fileContent = $this->removeRepeatWords ( $this->fileContent );
		$this->fileContent = $this->mergeSpace ( $this->fileContent );
		// 把一些重字母的去了
		$this->fileContent = $this->removeRepeatLetters ( $this->fileContent );
		$this->fileContent = $this->mergeSpace ( $this->fileContent );
		// 把驼峰替换掉
		$this->fileContent = $this->conversionHump ( $this->fileContent );

		// 把驼峰2替换掉
		$this->fileContent = $this->conversionHump2 ( $this->fileContent );

		// 把一些1-2个字母的都去了
		$this->fileContent = $this->removeLessLetters ( $this->fileContent );
		$this->fileContent = $this->mergeSpace ( $this->fileContent );
		
		// 转化成小写
		$this->fileContent = $this->conversionSmall ( $this->fileContent, $this->isOrder);
		
		// 去重单词
		$this->fileContent = $this->removeRepeatWords ( $this->fileContent );
		$this->fileContent = $this->mergeSpace ( $this->fileContent );
		$this->fileContent = trim ( $this->fileContent );

		// 删除非单词
		$this->fileContent = $this->delNoWords($this->dictionary, $this->fileContent);

		// $this->fileContent = $this->spaceToNewline ( $this->fileContent );
		return $this->fileContent;

	}

	/**
	 * 获取单词内容
	 */
	public function getNewWords(){
		$dictionary = file_get_contents ( "./myWords.txt" );
		$this->newFileContent = $this->getWords();
		// 删除已有单词
		$this->newFileContent = $this->delHasWords($dictionary, $this->newFileContent);
		// $this->fileContent = $this->spaceToNewline ( $this->fileContent );
		return $this->newFileContent;

	}

	/**
	 * 生成单词文件
	 */
	public function generateFile(){
		file_put_contents($this->generateFileName, $this->fileContent);
	}

	/**
	 * 添加新单词到我的单词
	 */
	public function addMyWordsFile( $somecontent ){
		$filename = $this->myWordsFile;

		// 首先我们要确定文件存在并且可写。
		if (is_writable($filename)) {

		    // 在这个例子里，我们将使用添加模式打开$filename，
		    // 因此，文件指针将会在文件的开头，
		    // 那就是当我们使用fwrite()的时候，$somecontent将要写入的地方。
		    if (!$handle = fopen($filename, 'a')) {
		         echo "不能打开文件 $filename";
		         exit;
		    }

		    // 将$somecontent写入到我们打开的文件中。
		    if (fwrite($handle, $somecontent) === FALSE) {
		        echo "不能写入到文件 $filename";
		        exit;
		    }

		    fclose($handle);

		} else {
		    echo "文件 $filename 不可写";
		}

	}
	/**
	 * 生成有道读的单词
	 */
	public function generateXML($contentText){
		// echo $contentText;
		$wordsArr = explode(' ', $contentText);
		$content = '';
		$content .= '<wordbook>';
		$content .=  "\r\n";
		foreach ($wordsArr as $key => $value) {
			$content .=  '  <item>';
			$content .=  "\r\n";
			$content .=  '    <word>'.$value.'</word>';
			$content .=  "\r\n";
			$content .=  '  </item>';
			$content .=  "\r\n";
		}
		$content .= '</wordbook>';
		return $content;
	}



	// ////////////////////// end public方法 ////////////////////////


	
	// 去掉其它，只留单词" [^a-zA-Z]+
	public function leaveWords($content) {
		$patterns = '/[^a-zA-Z]+/m';
		$replacements = " ";
		$content = preg_replace ( $patterns, $replacements, $content );
		return $content;
	}

	// 去掉重复单词
	public function removeRepeatWords($content) {
		$arr = explode ( " ", $content );
		$pieces = array_unique ( $arr );
		$content = implode ( " ", $pieces );
		return $content;
	}

	// 把驼峰替换掉 例：myBox 换成my Box
	public function conversionHump($content) {
		$patterns = '/([a-zA-Z])([A-Z])([a-z])/';
		$replacements = "$1 $2$3";
		$content = preg_replace ( $patterns, $replacements, $content );
		return $content;
	}

	// 把驼峰替换掉 例：myBox 换成my Box
	public function conversionHump2($content) {
		$patterns = '/([a-z])([A-Z])([a-zA-Z])/';
		$replacements = "$1 $2$3";
		$content = preg_replace ( $patterns, $replacements, $content );
		return $content;
	}

	// 把一些重字母的去了 例：aaaa bbb yyy 去掉
	public function removeRepeatLetters($content) {
		$patterns = '/([a-zA-Z])\1{2,}/';
		$replacements = "";
		$content = preg_replace ( $patterns, $replacements, $content );
		return $content;
	}
	// 把一些1-2个字母的都去了
	public function removeLessLetters($content) {
		$patterns = '/\b[a-zA-Z]{1,2}\b/';
		$replacements = " ";
		$content = preg_replace ( $patterns, $replacements, $content );
		return $content;
	}

	// 转化成小写
	public function conversionSmall($content, $cond = false) {
		$arr = explode ( " ", $content );
		$arr2 = array_map ( strtolower, $arr );
		$pieces = array_unique ( $arr2 );
		if( $cond ){
			sort ( $pieces );
		}
		$content = implode ( " ", $pieces );
		return $content;
	}

	// 合并空隔
	public function mergeSpace($content) {
		$patterns = '/\s+/';
		$replacements = " ";
		$content = preg_replace ( $patterns, $replacements, $content );
		return $content;
	}


	// 把空格转化成换行
	public function spaceToNewline($content) {
		$pieces = explode ( " ", $content );
		$content = implode ( "\n", $pieces );
		return $content;
	}

	// 删除非单词
	public function delNoWords( $dictionary, $content)  {
		$array1 = explode(" ", $dictionary);
		$array2 = explode(" ", $content);
		$result_arr = array_intersect($array2, $array1);
		// $this->wordsCounts = count( $result_arr )."\r\n";
		$content = implode(" ", $result_arr);
		return $content;
	}

	// 删除已有单词
	public function delHasWords( $dictionary, $content)  {
		$array1 = explode(" ", $dictionary);
		$array2 = explode(" ", $content);
		$array2 = array_reverse($array2);		
		$result_arr = array_diff($array2, $array1);
		$this->wordsCounts = count( $result_arr )."\r\n";
		$content = implode(" ", $result_arr);
		return $content;
	}



}
?>