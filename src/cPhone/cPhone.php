<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 10.02.14
 * Time: 10:18
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cPhone extends cCatalog{
	public $countryCode;

	public function convertPhone($ad) {
		//Находит телефон в объявлении и конвертирует под общий шаблон
		$c_w = '(?:\(|\)|\-|\_|\[|\]|\s+)*';
		$reg = "#(?<country_code>7|38|8)?$c_w((?<operator_code_ua>0(39|50|63|6[6-8]|9[1-9]))|(?<operator_code_ru>9([0-9]{2})))$c_w(?<1_number>\d)$c_w(?<2_number>\d)$c_w(?<3_number>\d)$c_w(?<4_number>\d)$c_w(?<5_number>\d)$c_w(?<6_number>\d)$c_w(?<7_number>\d)#ims";
		if (preg_match_all($reg, $ad, $phone_matches)) {
			//Это мобильный номер
			foreach ($phone_matches['1_number'] as $phone_key => $phone_value) {
				$phone = "+";
				if ($phone_matches['operator_code_ua'][$phone_key]) $phone .= "38" . $phone_matches['operator_code_ua'][$phone_key];
				elseif ($phone_matches['operator_code_ru'][$phone_key]) $phone .= "7" . $phone_matches['operator_code_ru'][$phone_key];
				for ($i = 1; $i <= 7; $i++) $phone .= $phone_matches[$i . '_number'][$phone_key];
				$phone_array[] = $phone;
			}
		}
		if (preg_match_all("#([^\d]{3}|^)(?<country_code>38|8)?$c_w(?<city_code>064([0-9]{1,2}))?$c_w(?<1_number>\d)$c_w(?<2_number>\d)$c_w(?<3_number>\d)$c_w(?<4_number>\d)$c_w(?<5_number>\d)$c_w(?<6_number>\d)?([^\d]{3}.*$|$)#ims", $ad, $phone_matches)) {
			// Это стационарный номер
			foreach ($phone_matches['1_number'] as $phone_key => $phone_value) {
				$phone = "";
				$phone .= $phone_matches['country_code'][$phone_key] . $phone_matches['city_code'][$phone_key];
				for ($i = 1; $i <= 6; $i++) $phone .= $phone_matches[$i . '_number'][$phone_key];
				$phone_array[] = $phone;
			}
		}
		if (!isset($phone_array)) {
			echo __FILE__ . __LINE__ . "Номер телефона не определен: " . $ad;
			return false;
		}
		return $phone_array;
	}
} 