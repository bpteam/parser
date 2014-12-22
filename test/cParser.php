<?php
/**
 * Created by PhpStorm.
 * User: ec
 * Date: 22.12.14
 * Time: 10:29
 * Project: fo_realty
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "cnfg_test.php";
require_once dirname(__FILE__) . '/../../loader/include.php';
use Parser\cParser as cParser;

class cTestParser extends cParser{

	function __construct(){
		parent::__construct();
		$this->catalog->setClassDir(dirname(__FILE__).'/support');
	}
}



$class = 'cParser';
$functions = array(
	'loadConfig',
	'parseListAds',
	'haveError',
);

echo $class ."</br>";

runTest($functions, $class.'_');


function cParser_loadConfig(){
	$parser = new cTestParser();
	$parser->catalog->loadConfig('reg_ex');
	return $parser->catalog->getConfig('ad_parent') == '%(?<text>.*)%imsu';
}

function cParser_parseListAds(){
	$parser = new cTestParser();
	$html = '
	<div class="list">
		<p><a href="asdf/asdf/1234">blablabla</a></p>
		<p><a href="asdf/asdf/4321">ulalala</a></p>
		<p><a href="asdf/asdf/1111">uuuueeeee</a></p>
	</div>
	';
	$parser->parseListAds($html);
	$units = $parser->catalog->getUnits();
	return isset($units['asdf/asdf/1234']) && isset($units['asdf/asdf/4321']) && isset($units['asdf/asdf/1111']);
}

function cParser_haveError(){
	$parser = new cTestParser();
	$parser->catalog->loadConfig('reg_ex');
	$html = '<h1>404 куды залез?</h1>';
	$parser->parseAd('some_key', $html);
	$error404 = $parser->getLastError();
	$html = '<div class="message">Чет ты не то ищешь. Братюнь, приходи потом, может че и будет</div>';
	$parser->parseListAds($html);
	$errorEmptyList = $parser->getLastError();
	return $error404 == 'page is 404' && $errorEmptyList == 'list is empty';
}