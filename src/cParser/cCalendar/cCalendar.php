<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 13:44
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cCalendar  extends cCatalog{
	protected $_month, $_chronology, $_typeTime, $_time, $_deleteSign;
	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_chronology = $this->loadConfig('chronology');
		$this->_month = $this->loadConfig('month');
		$this->_typeTime = $this->loadConfig('type_time');
		$this->_time = $this->loadConfig('time');
		$this->_deleteSign = $this->loadConfig('delete_sign');
	}

	public function getTimestamp($text, $lang = 'ru', $DataTimeFormat = null){
		$time = $this->convertToStrToTime($text, $lang);
		if($DataTimeFormat){
			$dt = \DateTime::createFromFormat ( $DataTimeFormat, $time);
			return $dt->getTimestamp();
		} else {
			return strtotime($time);
		}
	}

	private function replace( &$text, $patterns){
		foreach($patterns as $data => $pattern){
			$text = preg_replace($pattern, $data, $text);
		}
	}

	public function getMonthName($text, $lang = 'ru'){
		foreach($this->_month[$lang] as $data => $pattern){
			if(preg_match($pattern,$text)){
				return $data;
			}
		}
		return false;
	}

	public function getChronologyName($text, $lang = 'ru'){
		foreach($this->_chronology[$lang] as $data => $pattern){
			if(preg_match($pattern,$text)){
				return $data;
			}
		}
		return false;
	}

	public function convertToStrToTime($text, $lang = 'ru'){
		$this->replace($text, $this->_month[$lang]);
		$this->replace($text, $this->_time[$lang]);
		$this->replace($text, $this->_chronology[$lang]);
		if(preg_match($this->_typeTime[$lang]['back'], $text)){
			$this->replace($text, $this->_deleteSign[$lang]);
			$text = preg_replace($this->_typeTime[$lang]['back'], '', $text);
			$text = '-'.trim($text);
		} else {
			$this->replace($text, $this->_deleteSign[$lang]);
			$text = trim($text);
		}
		return $text;
	}
}