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
	protected $_month;
	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_chronology = $this->loadConfig('chronology');
		$this->_month = $this->loadConfig('month');
	}

	public function getTimestamp($text, $lang = 'ru'){
		$this->replace($text, $this->_month[$lang]);
		$this->replace($text, $this->_chronology[$lang]);
		return strtotime($text);
	}

	private function replace( &$text, $patterns){
		foreach($patterns as $data => $pattern){
			$text = preg_replace($pattern, $data, $text);
		}
	}
}