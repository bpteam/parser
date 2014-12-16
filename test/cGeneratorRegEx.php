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
	'buildOrFromArray',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cGeneratorRegEx_fromHtmlTag(){
	$html = '<div class="hello_world" id="testid">';
	$regEx = cGeneratorRegEx::fromHtmlTag($html);
	return $regEx == '\s*<div[^>]*\s*class\s*=\s*["\']?hello_world["\']?\s*id\s*=\s*["\']?testid["\']?[^>]*>\s*';
}

function cGeneratorRegEx_buildOrFromArray(){
	$test = array(
		'uk' => array(
			'golden_telecom' => array('039'),
			'mts' => array('050','066','095','099'),
			'life'=> array('063','093'),
			'kievstar' =>array('067','096','097','098',),
			'beeline'=>array('068'),
			'utel'=>array('091'),
			'peoplenet'=>array('092'),
			'intertelecom'=>array('091'),
		),
		'ru' => array(
			'ru' => array('900', '901', '902', '903', '904', '905', '906', '908', '909', '910', '911', '912', '913', '914', '915', '916', '917', '918', '919', '920', '921', '922', '923', '924', '925', '926', '927', '928', '929', '930', '931', '932', '933', '934', '936', '937', '938', '939', '941', '950', '951', '952', '953', '954', '955', '956', '958', '960', '961', '962', '963', '964', '965', '966', '967', '968', '969', '970', '971', '980', '981', '982', '983', '984', '985', '987', '988', '989', '991', '992', '993', '994', '995', '996', '997', '999'),
		),
	);
	return cGeneratorRegEx::buildOrFromArray($test) == '(039|050|066|095|099|063|093|067|096|097|098|068|091|092|900|901|902|903|904|905|906|908|909|910|911|912|913|914|915|916|917|918|919|920|921|922|923|924|925|926|927|928|929|930|931|932|933|934|936|937|938|939|941|950|951|952|953|954|955|956|958|960|961|962|963|964|965|966|967|968|969|970|971|980|981|982|983|984|985|987|988|989|991|992|993|994|995|996|997|999)';
}