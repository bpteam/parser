<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 05.02.14
 * Time: 14:21
 * Email: bpteam22@gmail.com
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "cnfg_test.php";
use Parser\cGeneratorRegEx as cGeneratorRegEx;
$class = 'cGeneratorRegEx';
$functions = array(
	'fromHtmlTag',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cGeneratorRegEx_fromHtmlTag(){
	$html = '<div class="hello_world" id="testid">';
	$regEx = cGeneratorRegEx::fromHtmlTag($html);
	return $regEx == '%\s*<div[^>]*\s*class\s*=\s*["\']?hello_world["\']?\s*id\s*=\s*["\']?testid["\']?[^>]*>\s*%';
}