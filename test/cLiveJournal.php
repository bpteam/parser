<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 15.03.14
 * Time: 14:16
 * Project: livejornal
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "cnfg_test.php";

$class = 'cLiveJournal';
$functions = array(
	//'comments',
	'parsArticle',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cLiveJournal_comments(){
	$lj = new \Parser\cLiveJournal();
	$lj->setJournal('navalny');
	$lj->setId(915012);
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	$lj->getArticleComments($page);
	$count = count($lj->getComments());
	return $count > 1000;
}


function cLiveJournal_parsArticle(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/1626227.html';
	$page = file_get_contents($url);
	$lj->setJournal($lj->getArticleJournal($page));
	$lj->findArticleBlock($lj->getJournal());
	$lj->parsArticle($page);
}