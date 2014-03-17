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
	'getLinks',
	'comments',
	'getArticleId',
	'getArticleJournal',
	'getArticleTitle',
	'findArticleBlock',
	'getArticleText',
	'getArticleTag',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cLiveJournal_getLinks(){
	$lj = new \Parser\cLiveJournal();
	$page = file_get_contents('http://tema.livejournal.com/1626227.html');
	$links = $lj->getLinks($page);
	return 'иллюстрация' == $tag[1];
}

function cLiveJournal_comments(){
	$lj = new \Parser\cLiveJournal();
	$lj->setJournal('navalny');
	$lj->setId(915012);
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	$lj->getArticleComments($page);
	$count = count($lj->getComments());
	return $count > 1000;
}

function cLiveJournal_getArticleId(){
	$lj = new \Parser\cLiveJournal();
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	return '915012' == $lj->getArticleId($page);
}

function cLiveJournal_getArticleJournal(){
	$lj = new \Parser\cLiveJournal();
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	return 'navalny' == $lj->getArticleJournal($page);
}

function cLiveJournal_getArticleTitle(){
	$lj = new \Parser\cLiveJournal();
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	return 'и виртуалы зловредные, и технотроны беспощадные' == $lj->getArticleTitle($page);
}

function cLiveJournal_findArticleBlock(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/1626227.html';
	$page = file_get_contents($url);
	$lj->setJournal($lj->getArticleJournal($page));
	$lj->findArticleBlock($lj->getJournal());
	return '<article class="b-singlepost-body">' == $lj->getArticleBlock();
}

function cLiveJournal_getArticleText(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/1626227.html';
	$page = file_get_contents($url);
	$lj->setJournal($lj->getArticleJournal($page));
	$lj->findArticleBlock($lj->getJournal());
	$text = mb_substr(htmlspecialchars_decode($lj->getArticleText($page)),0,99,'utf-8');
	return ' <center><img src="http://www.tema.ru/jjj/kexp/kexp.gif"></center><br /><br /><br />Едем на аэродро' == $text;
}

function cLiveJournal_getArticleTag(){
	$lj = new \Parser\cLiveJournal();
	$page = file_get_contents('http://tema.livejournal.com/1626227.html');
	$tag = $lj->getArticleTag($page);
	return 'иллюстрация' == $tag[1];
}

function cLiveJournal_parsArticle(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/1626227.html';
	$page = file_get_contents($url);
	$lj->setJournal($lj->getArticleJournal($page));
	$lj->findArticleBlock($lj->getJournal());
	$lj->parsArticle($page);
}