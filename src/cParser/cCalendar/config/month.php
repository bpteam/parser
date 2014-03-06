<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 13:46
 * Email: bpteam22@gmail.com
 */
$endWordRu1 = '(ь|я|е|ю)';
$endWordRu2 = '(а|е|у|)';
return array(
	'ru' => array(
		'January'  => "%ян(\.|(в(\.|ар$endWordRu1|))|)%imsu",
		'February' => "%фев(\.|рал$endWordRu1|)%imsu",
		'March'    => "%мар(\.|(т$endWordRu2)|)%imsu",
		'April'    => "%ап(\.|р(\.|ел$endWordRu1)|)%imsu",
		'May'      => "%ма(й|я|е|ю)%imsu",
		'June'     => "%июн(\.|$endWordRu1|)%imsu",
		'July'     => "%июл(\.|$endWordRu1|)%imsu",
		'August'   => "%авг(\.|(уст$endWordRu2)|)%imsu",
		'September'=> "%сен(\.|(тябр$endWordRu1)|)%imsu",
		'October'  => "%ок(\.|т(\.|ябр$endWordRu1)|)%imsu",
		'November' => "%ноя(\.|(бр$endWordRu1)|)%imsu",
		'December' => "%дек(\.|абр$endWordRu1|)%imsu",
	),

);