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

	private $_regExTypeSettle;
	private $_regExTypeApartment;

	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_regExTypeSettle = $this->loadConfig('type_settle');
		$this->_regExTypeApartment = $this->loadConfig('apartment_');
	}

	/**
	 * @param string $text
	 * @param array  $pattern array('moscow' => '%Моско?в(а|ы|е|(ск(ой|ая)))%imsu', 'new_york'=>'Нью-йорк')
	 * @return bool|string
	 */
	public function getSettleName($text, $pattern){
		$answer = $this->parsingText($text, $pattern);
		return count($answer) ? $answer['find'][0] : false;
	}

	public function getSettleType($text, $lang = 'ru'){
		$answer = $this->parsingText($text, $this->_regExTypeSettle[$lang]);
		return count($answer) ? $answer[0] : false;
	}

	public function getTypeApartment($text, $lang = 'ru'){
		$answer = $this->parsingText($text, $this->_regExTypeApartment[$lang]);
		return count($answer) ? $answer['find'][0] : false;
	}
} 