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
	private $_countryCode;
	private $_settleCode;
	private $_mobileCode;
	private $_separator = '(?:\(|\)|\-|\_|\[|\]|\s+){0,3}';

	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_countryCode = $this->loadConfig('country_code');
		$this->_mobileCode = $this->loadConfig('mobile_code');
		$this->_settleCode = $this->loadConfig('settle_code');
	}

	public function findMobile($text){
		$regEx = '%(?<phone>(?<country_code>' . cGeneratorRegEx::buildOrFromArray($this->_countryCode) . ')?' . $this->_separator . '(?<provider>' . cGeneratorRegEx::buildOrFromArray($this->_mobileCode) . "){$this->_separator}(?<1_number>\\d){$this->_separator}(?<2_number>\\d){$this->_separator}(?<3_number>\\d){$this->_separator}(?<4_number>\\d){$this->_separator}(?<5_number>\\d){$this->_separator}(?<6_number>\\d){$this->_separator}(?<7_number>\\d))%ims";
		$data = $this->parsingText($text,$regEx);
		return $data ? $this->buildNumber($data, 'phone', array('country_code', 'provider', '1_number', '2_number', '3_number', '4_number', '5_number', '6_number', '7_number')) : array();
	}

	public function findHome($text){
		$regEx = '%([^\d]{3}\s*|^)(?<phone>(?<country_code>' . cGeneratorRegEx::buildOrFromArray($this->_countryCode). ')?' . $this->_separator . "(?<settle_code>" . cGeneratorRegEx::buildOrFromArray($this->_settleCode) . ")?{$this->_separator}(?<1_number>\\d){$this->_separator}(?<2_number>\\d){$this->_separator}(?<3_number>\\d){$this->_separator}(?<4_number>\\d){$this->_separator}(?<5_number>\\d){$this->_separator}(?<6_number>\\d)?{$this->_separator}(?<7_number>\\d)?)([^\\d]{3}.*$|$)%ims";
		$data = $this->parsingText($text,$regEx);
		return $data ? $this->buildNumber($data, 'phone', array('country_code', 'settle_code', '1_number', '2_number', '3_number', '4_number', '5_number', '6_number', '7_number')) : array();

	}

	public function findPhone($text){
		$mobile = $this->findMobile($text);
		$home = $this->findHome($text);
		return array_merge($mobile,$home);
	}

	private function buildNumber($data, $rowName = 'phone', $pattern = array('country_code', 'settle_code', 'number')){
		$phones = array();
		foreach($data[$rowName] as $key => $value){
			$phone = '';
			foreach($pattern as $colName){
				if(isset($data[$colName][$key])){
					$phone .= $data[$colName][$key];
				}
			}
			$phones[] = $phone;
		}
		return $phones;
	}
}