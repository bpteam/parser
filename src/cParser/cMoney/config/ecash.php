<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 04.03.14
 * Time: 16:31
 * Email: bpteam22@gmail.com
 */
$webMoney = 'w(?:eb)?m(?:oney)?\s*';
return array(
	'WMR' => "%{$webMoney}r%i",
	'WME' => "%{$webMoney}e%i",
	'WMZ' => "%{$webMoney}z%i",
	'WMU' => "%{$webMoney}u%i",
	'WMY' => "%{$webMoney}y%i",
	'WMB' => "%{$webMoney}b%i",
	'WMG' => "%{$webMoney}g%i",
	'WMX' => "%{$webMoney}x%i",
	'Яндекс.Деньги' => '%(Я(?:нд(?:екс|\.|)?)?\s*\.?\s*Д?(?:еньги)|Ya?(?:ndex)?\.?M?(?:oney)?)?%imsu',
);