<?php 
include('classes/extractWords.class.php');

$extractText = new extractWords();

// $extractText->isOrder = true; 
$extractText->file = './words/angular.js';
$title = "angular 相关单词\r\n ";
$words = $extractText->getNewWords();
$content = $title.$words." \r\n";

echo $extractText->generateXML($words);


echo $extractText->wordsCounts;



// echo $content;
if ( $extractText->wordsCounts > 0){
	$extractText->addMyWordsFile($content);
}
// $extractText->generateFileName = './result/javascript.txt';
// $extractText->generateFile();

?>