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
	'categories',
	'unitList_grouping',
	'unit',
	'pagination',
	'nextPage',
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
	$html = '
	<html>
	<head></head>
	<body>
		<div id="content">
			<h1>Title ad</h1>
			<div><span>Speed:</span><b>125</b></div>
			<div><span>Color:</span><b>red</b></div>
			<div><span>Color:</span><b>blue</b></div>
		</div>
	</body>
	</html>
	';
	$parser = new cCatalog();
	$parser->unit('/ad1', $html, array('%<h1>(?<title>[^<]*)</h1>%ims', '%Speed:</span><b>(?<speed>\d+)</b>%ims', '%Color:</span><b>(?<color>\w+)</b>%ims'), '%<div\s*id="content">(?<text>.*)</body>%ims');
	$unit = $parser->getUnit('/ad1');
	return $unit['title'][0] == 'Title ad' && $unit['speed'][0] == '125' && $unit['color'][0] == 'red' && $unit['color'][1] == 'blue';
}

function cCatalog_pagination(){
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
		<div class="pagination"><a href="part_url/page/1">PREV</a> | <a href="part_url/page/1">1</a> | 2 | <a href="part_url/page/3">3</a> | <a href="part_url/page/4">4</a> | <a href="part_url/page/5">5</a> | <a href="part_url/page/3">NEXT</a></div>
	</body>
	</html>
	';
	$parser = new cCatalog();
	$pagination = $parser->pagination($html, '%<a href="(?<url>part_url/page/(?<num>\d*))">%ims', '%<div\s*class="pagination">(?<text>.*)</div>%imsU');
	return $pagination[1] = 'part_url/page/1' && $pagination[3] = 'part_url/page/3' && $pagination[4] = 'part_url/page/4' && $pagination[5] = 'part_url/page/5';
}

function cCatalog_nextPage(){
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
		<div class="pagination"><a href="part_url/page/2">PREV</a> | <a href="part_url/page/1">1</a> | <a href="part_url/page/2">2</a> | 3 | <a href="part_url/page/4">4</a> | <a href="part_url/page/5">5</a> | <a href="part_url/page/4">NEXT</a></div>
	</body>
	</html>
	';
	$parser = new cCatalog();
	$parser -> setCurrentPage(3);
	$nextPage = $parser->nextPage($html, '%<a href="(?<url>part_url/page/(?<num>\d*))">%ims', '%<div\s*class="pagination">(?<text>.*)</div>%imsU');
	return $nextPage == 'part_url/page/4';
}