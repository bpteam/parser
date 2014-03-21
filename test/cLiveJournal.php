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
	'getArticleId',
	'getArticleJournal',
	'getArticleTitle',
	'findArticleBlock',
	'init',
	'getLinks',
	'nextPage',
	'getArticleText',
	'getArticleTag',
	'comments',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cLiveJournal_init(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/';
	$lj->init($url);
	return 'tema' == $lj->getJournal() && '<article class="b-singlepost-body">' == $lj->getArticleBlock();
}

function cLiveJournal_getLinks(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/';
	$page = file_get_contents($url);
	$lj->init($url);
	$links = $lj->getLinks($page);
	return 10 == count($links);
}

function cLiveJournal_nextPage(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/';
	$lj->init($url);
	$page = file_get_contents($url);
	$links1 = $lj->getLinks($page);
	$url = $lj->nextPage($page);
	$page = file_get_contents($url);
	$links2 = $lj->getLinks($page);
	$url = $lj->nextPage($page);
	$page = file_get_contents($url);
	$links3 = $lj->getLinks($page);
	$links = array_merge($links1, $links2, $links3);
	$links = array_unique($links);
	return 30 == count($links);
}

function cLiveJournal_comments(){
	$lj = new \Parser\cLiveJournal();
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	$lj->setJournal($lj->getArticleJournal($page));
	$lj->setPostId($lj->getArticleId($page));
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
	$url = 'http://tema.livejournal.com/';
	$lj->init($url);
	return '<article class="b-singlepost-body">' == $lj->getArticleBlock();
}

function cLiveJournal_getArticleText(){
	$lj = new \Parser\cLiveJournal();
	$url = 'http://tema.livejournal.com/';
	$lj->init($url);
	$url = 'http://tema.livejournal.com/1626227.html';
	$page = file_get_contents($url);
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