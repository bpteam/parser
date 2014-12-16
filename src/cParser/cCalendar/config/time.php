<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 29.04.14
 * Time: 13:26
 * Project: fo_realty
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

return array(
	'ru' => array(
		'year'    => '(?:[^\w]|^|\s)(год(а|)|лет)(?:[^\w]|$|\s)',
		'day'     => '(?:[^\w]|^|\s)д(н(я|ей)|ень)(?:[^\w]|$|\s)',
		'hour'    => '(?:[^\w]|^|\s)час(ов|а|)(?:[^\w]|$|\s)',
		'minutes' => '(?:[^\w]|^|\s)мин(ут(а|ы|)|\.)(?:[^\w]|$|\s)',
		'seconds' => '(?:[^\w]|^|\s)сек(унд(а|ы|)|\.)(?:[^\w]|$|\s)',
	),
);