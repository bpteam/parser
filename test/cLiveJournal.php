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
	'comments',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cLiveJournal_comments(){
	$lj = new \Parser\cLiveJournal();
	$lj->setJournal('navalny');
	$lj->setArticleData('id', 915012);
	$page = file_get_contents('http://navalny.livejournal.com/915012.html');
	$lj->getAllComments($page);
	var_dump($lj->getComments());
}