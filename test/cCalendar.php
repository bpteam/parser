<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 21:30
 * Project: bezagenta.lg.ua
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "cnfg_test.php";

$class = 'cCalendar';
$functions = array(
	'month',
	'chronology',
	'getTimestamp',
);

echo $class ."</br>";

runTest($functions, $class.'_');

function cCalendar_month(){
	$calendar = new \Parser\cCalendar();
	$monthLines = array( 'January'   => "январь января январю январём январе",
	                     'February'  => "февраль февраля февралю февралём феврале",
	                     'March'     => "март марта марту мартом марте",
	                     'April'     => "апрель апреля апрелю апрелем апреле",
	                     'May'       => "май мая маю маем мае",
	                     'June'      => "июнь июня июнем июне",
	                     'July'      => "июль июля июлем июле",
	                     'August'    => "август августа августу августом августе",
	                     'September' => "сентябрь сентября сентябрю сентябрём сентябре",
	                     'October'   => "октябрь октября октябрю октябрём октябре",
	                     'November'  => "ноябрь ноября ноябрю ноябрём ноябре",
	                     'December'  => "декабрь декабря декабрю декабрём декабре",);
	foreach($monthLines as $name => $monthText){
		$monthNames = explode(" ", $monthText);
		foreach($monthNames as $monthWord){
			if($name != $calendar->getMonthName($monthWord)){
				return false;
			}
		}
	}
	return true;
}

function cCalendar_chronology(){
	$calendar = new \Parser\cCalendar();
	$chronologyLines = array(
		'yesterday' => 'вчера вчерашний вчерашнего вчерашнему вчерашняя вчерашней вчерашнюю вчерашние вчерашних вчерашним вчерашними',
		'today' => 'сегодня сегодняшний сегодняшнего сегодняшнему сегодняшняя сегодняшней сегодняшнюю сегодняшние сегодняшних сегодняшним сегодняшними',
		'tomorrow' => 'завтра завтрашний завтрашнего завтрашнему завтрашняя завтрашней завтрашнюю завтрашние завтрашних завтрашним завтрашними',
	);
	foreach($chronologyLines as $name => $chronologyText){
		$chronologyNames = explode(" ", $chronologyText);
		foreach($chronologyNames as $chronologyWord){
			if($name != $calendar->getChronologyName($chronologyWord)){
				return false;
			}
		}
	}
	return true;
}

function cCalendar_getTimestamp(){
	$calendar = new \Parser\cCalendar();
	$timeTest = ' вчера в 11:09';
	$timeResult = strtotime('yesterday 11:09');
	$timeTest2 = ' 1 июня в 23:06';
	$dt = \DateTime::createFromFormat('j F H:i', '1 June 23:06');
	$timeResult2 = $dt->getTimestamp();
	$result1 = $timeResult == $calendar->getTimestamp($timeTest, 'ru');
	$result2 = $timeResult2 == $calendar->getTimestamp($timeTest2, 'ru', 'j F H:i');
	return $result1 && $result2;
}