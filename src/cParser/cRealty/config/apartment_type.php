<?
$room_ru = "((\\s*|\\.|,)?ком($|\\s|\\.|н($|\\s|\\.|ат($|\\s|\\.|а|у|ы|н(ая|ую|ой)))))";
$flat_ru = "((\\s*|^|\\.|,)кв(\\s*|\\.|ар(\\.|\\s|$|тир(у|а|е|ой))))";
$one_room_ru   = "(1|одн(о|а))";
$two_room_ru   = "(2|дв(е|ух))";
$three_room_ru = "(3|тр(и|(е|ё)х))";
$four_room_ru  = "(4|четыр(е|(е|ё)х))";
$or_ru = "(\\-|,|и|или|\\s)*";
$house_ru = "(дом(e|ом)?)";
$outbuilding_ru = "(флигел(ь|е|я))";
return array(
	'ru' => array(
		'1_room_flat' => "%(?<find>{$one_room_ru}({$or_ru}|{$two_room_ru}|{$three_room_ru}|{$four_room_ru})*\\s*{$room_ru}\\s*{$flat_ru}?)%imsu",
		'2_room_flat' => "%(?<find>{$two_room_ru}({$or_ru}|{$three_room_ru}|{$four_room_ru})*\\s*{$room_ru}\\s*{$flat_ru}?)%imsu",
		'3_room_flat' => "%(?<find>{$three_room_ru}({$or_ru}|{$four_room_ru})*\\s*{$room_ru}\\s*{$flat_ru}?)%imsu",
		'4_room_flat' => "%(?<find>{$four_room_ru}\\s*{$room_ru}\\s*{$flat_ru}?)%imsu",
		'house' => "%(?<find>(\\s|^|\\.|,)($house_ru|$outbuilding_ru)(\\s|$|\\.|,))%imsu",
	),
	'en' => array(),
	'ua' => array(),
);