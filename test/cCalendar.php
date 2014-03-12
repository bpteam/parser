<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 21:30
 * Project: bezagenta.lg.ua
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "cnfg_test.php";

$class = 'cCalendar';
$functions = array(
	'month',
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

}