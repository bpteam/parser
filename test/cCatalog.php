<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 04.02.14
 * Time: 15:01
 * Email: bpteam22@gmail.com
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "cnfg_test.php";
use Parser\cCatalog as cCatalog;
$class = 'cCatalog';
$functions = array(
	//'categories',
	'unitList_grouping',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cCatalog_categories(){
	$html = '
	<html>
	<head></head>
	<body>
		<div class="menu">
		<ul>
			<li>
				<a href="/cat1">cat1</a>
			</li>
			<li>
				<a href="/cat2">cat2</a>
			</li>
			<li>
				<a href="/cat3">cat3</a>
			</li>
		</ul>
		</div>
	</body>
	</html>
	';

	$parser = new cCatalog();
	$parser->categories($html, '%<a[^>]*href=[\'"](?<url>[^\'"]+)[\'"][^>]*>(?<name>[^<]+)</a>%', '%<div[^>]*class\s*=\s*[\'"]menu[\'"][^>]*>(?<text>.+)</div>%imsU');
	$categories = $parser->getCategories();
	return $categories['cat1'] == '/cat1' && $categories['cat2'] == '/cat2' && $categories['cat3'] == '/cat3';
}

function cCatalog_unitList_grouping(){
	$html = '
	<html>
	<head></head>
	<body>
		<div id="list">
			<a href="/ad1">
				<img src="/pic1.png" /> Super-puper <b>%35</b>
			</a>
			<a href="/ad2">
				<img src="/pic2.png" /> Para-truper <b>%50</b>
			</a>
			<a href="/ad3">
				<img src="/pic3.png"/> Hali-gali <b>%15</b>
			</a>
		</div>
	</body>
	</html>
	';

	$parser = new cCatalog();
	$parser->unitList($html, '%<a[^>]*href\s*=\s*[\'"](?<unique>[^\'"]+)[\'"][^>]*>\s*<img\s*src=[\'"](?<img>[^\'"]*)[\'"][^>]*>\s*(?<name>[^<]+)\s*<b>(?<percent>\%\d+)</b>\s*</a>%ims', '%<div[^>]*id\s*=\s*[\'"]list[\'"][^>]*>(?<text>.+)</div>%imsU');
	$units = $parser->getUnits();
	return !array_diff(array('unique'=>'/ad1', 'img'=>'/pic1.png', 'name'=>'Super-puper', 'percent'=>'%35'), $units['/ad1'])
	    && !array_diff(array('unique'=>'/ad2', 'img'=>'/pic2.png', 'name'=>'Para-truper', 'percent'=>'%50'), $units['/ad2'])
	    && !array_diff(array('unique'=>'/ad3', 'img'=>'/pic3.png', 'name'=>'Hali-gali',   'percent'=>'%15'), $units['/ad3']);
}

function cCatalog_unit(){

}

function cCatalog_pagination(){

}

function cCatalog_nextPage(){

}