<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 13:46
 * Email: bpteam22@gmail.com
 */
$endWordRu1 = '(ь|я|ем?|ю|ём)';
$endWordRu2 = '(а|ем?|у|ом|)';
return array(
	'ru' => array(
		'January'  => "ян(\.|(в(\.|ар$endWordRu1|))|)",
		'February' => "фев(\.|рал$endWordRu1|)",
		'March'    => "мар(\.|(т$endWordRu2)|)",
		'April'    => "ап(\.|р(\.|ел$endWordRu1)|)",
		'May'      => "ма(й|я|ем?|ю)",
		'June'     => "июн(\.|$endWordRu1|)",
		'July'     => "июл(\.|$endWordRu1|)",
		'August'   => "авг(\.|(уст$endWordRu2)|)",
		'September'=> "сен(\.|(тябр$endWordRu1)|)",
		'October'  => "ок(\.|т(\.|ябр$endWordRu1)|)",
		'November' => "ноя(\.|(бр$endWordRu1)|)",
		'December' => "дек(\.|абр$endWordRu1|)",
	),

);