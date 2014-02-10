<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 10.02.14
 * Time: 10:16
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cRealty extends cCatalog{

	public $typeSettle;

	function __construct(){
		$this->typeSettle = $this->loadConfig('type_settle');
	}

	public static function analysedAdRealty($text) {

		$pattern = array(
			'city' => array(
				'lg' => '%((в)?(((Г|г)\.?)|(Г|г)оро(д|де)|(Г|г)о(р|р\.))\s*(Л|л)(уг|УГ)\.?(анск|АНСК)?(е|Е|А|а)?|(Л|л)(уг|УГ)\.?(анск|АНСК)?(е|Е|А|а)?\s*(((Г|г)\.?)|(Г|г)оро(д|де)|(Г|г)о(р|р\.)))%uims',
			),
		);
		//Определение города
		switch (1) {
			case preg_match('#((в|В)?(((Г|г)\.?)|(Г|г)оро(д|де)|(Г|г)о(р|р\.))\s*(Л|л)(уг|УГ)\.?(анск|АНСК)?(е|Е|А|а)?|(Л|л)(уг|УГ)\.?(анск|АНСК)?(е|Е|А|а)?\s*(((Г|г)\.?)|(Г|г)оро(д|де)|(Г|г)о(р|р\.)))#ims', $text):
				$data['city'] = 'lg';
				break;
			case preg_match('#((в|(г\.|г)|горо(д|де)|го(р|р\.))\s*(С|C|c|с)част(e|ье|я|ья)|(С|C|c|с)част(e|ье|я|ья)\s*(((Г|г)\.?)|(Г|г)оро(д|де)|(Г|г)о(р|р\.)))#ims', $text):
				$data['city'] = 'sch';
				break;
			default:
				$data['city'] = '?';
		}
		//Типа объявлений (Сниму|Продам|Сдам|Куплю) пока не нужно
		switch (1) {
			default:
				$data['type_ad'] = '?';
		}
		return $data;
	}

	/**
	 * @param string $text
	 * @param array  $pattern array('moscow' => '%Моско?в(а|ы|е|(ск(ой|ая)))%imsu', 'new_york'=>'Нью-йорк')
	 * @return bool|string
	 */
	public function getSettleName($text, $pattern){
		$answer = $this->search($text, $pattern);
		return count($answer) ? $answer[0] : false;
	}

	public function getSettleType($text){

	}

	/**
	 * @param string $text
	 * @param array  $pattern
	 * @return array
	 */
	private function search($text, $pattern){
		$data = array();
		foreach($pattern as $name => $regEx){
			if(preg_match($regEx, $text)){
				$data[] = $name;
			}
		}
		return $data;
	}

	public function getTypeApartment($text){
		switch (1) {
			case preg_match('#(1\s*(\-|,)?(\s*(или|ИЛИ)\s*)\d*|1)\s*-?(К|к)(о|О|і|І)?(м|М)?(\.|Н|н|н\.|Н\.|нат|нат\.|натная|ную|ной)?(\s|,|\.|\/)#ims', $text):
				$data['type_house'] = '1_room';
				break;
			case preg_match('#(\-?2\s*(\-|,)?(\s*(или|ИЛИ)\s*)*\d*|2)\s*-?(К|к)(о|О|і|І)?(м|М)?(\.|Н|н|н\.|Н\.|нат|нат\.|натная|ную|ной)?(\s|,|\.|\/)#ims', $text):
				$data['type_house'] = '2_room';
				break;
			case preg_match('#(\-?3\s*(\-|,)?(\s*(или|ИЛИ)\s*)?\d*|3)\s*-?(К|к)(о|О|і|І)?(м|М)?(\.|Н|н|н\.|Н\.|нат|нат\.|натная|ную|ной)?(\s|,|\.|\/)#ims', $text):
				$data['type_house'] = '3_room';
				break;
			case preg_match('#(\-?(4|5)\s*(\-|,)?(\s*(или|ИЛИ)\s*)*\d*|(4|5))\s*-?(К|к)(о|О|і|І)?(м|М)?(\.|Н|н|н\.|Н\.|нат|нат\.|натная|ную|ной)?(\s|,|\.|\/)#ims', $text):
				$data['type_house'] = '4_room';
				break;
			case preg_match('#((Д|д)(ом|ОМ)|(Ф|ф)(лигель|ЛИГЕЛЬ))(\s*(или|ИЛИ|,|-)\s*)*((Д|д)(ом|ОМ)|(Ф|ф)(лигель|ЛИГЕЛЬ))?#ims', $text):
				$data['type_house'] = 'house';
				break;
			case preg_match('#(К|к)(вартир|ВАРТИР)(У|у|А|a)#ims', $text):
				$data['type_house'] = 'apartment';
				break;
			default:
				$data['type_house'] = '?';
		}
	}

	public function compilationAd($adData){
		$ad = '';
		if(isset($adData['title'])){
			$ad .= $adData['title'].' ';
		}
		if(isset($adData['ad_from'])){
			$ad .= $adData['ad_from'].' ';
		}
		if(isset($adData['type_ad'])){
			$ad .= $adData['type_ad'].' ';
		}
		if(isset($adData['text'])){
			$ad .= $adData['text'].' ';
		}
		if(isset($adData['rent_type'])){
			$ad .= 'на '.$adData['rent_type'].' условиях ';
		}
		if(isset($adData['count_room'])){
			$ad .= $adData['count_room'].' ';
		}
		if(isset($adData['city'])){
			$ad .= 'в ' . $adData['city'].' ';
		}
		if(isset($adData['address'])){
			$ad .= 'по ' . $adData['address'].' ';
		}
		if(isset($adData['floor'])){
			$ad .= $adData['floor'].' ';
		}
		if(isset($adData['count_floor'])){
			$ad .= $adData['count_floor'].' ';
		}
		if(isset($adData['type_house'])){
			$ad .= $adData['type_house'].' дома ';
		}
		if(isset($adData['square'])){
			$ad .= 'общая площадь ' . $adData['square'].' ';
		}
		if(isset($adData['living_square'])){
			$ad .= 'жилая площадь ' . $adData['living_square'].' ';
		}
		if(isset($adData['kitchen_square'])){
			$ad .= 'площадь кухни ' . $adData['kitchen_square'].' ';
		}
		if(isset($adData['price'])){
			$ad .= 'цена ' . $adData['price'].' ';
		}
		if(isset($adData['rent_date'])){
			$ad .= 'Предложение актуально с ' . $adData['rent_date'].' ';
		}
		if(isset($adData['rent_date']) && isset($adData['actual_date'])){
			$ad .= 'по ' . $adData['actual_date'].' ';
		}
		if(isset($adData['contact_person'])){
			$ad .= $adData['contact_person'].' ';
		}
		if(isset($adData['public_date'])){
			$ad .= $adData['public_date'].' ';
		}
		$returnAd['text'] = $ad;
		$returnAd['phone'] = $adData['phone'];
		return $returnAd;
	}
} 