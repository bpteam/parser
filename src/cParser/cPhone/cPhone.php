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
		$this->mobileRegEx = '%(?<phone>(?<country_code>' . cGeneratorRegEx::buildOrFromArray($this->_countryCode) . ')?' . $this->_separator . '(?<provider>' . cGeneratorRegEx::buildOrFromArray($this->_mobileCode) . "){$this->_separator}(?<1_number>\\d){$this->_separator}(?<2_number>\\d){$this->_separator}(?<3_number>\\d){$this->_separator}(?<4_number>\\d){$this->_separator}(?<5_number>\\d){$this->_separator}(?<6_number>\\d){$this->_separator}(?<7_number>\\d))%ims";
		$this->homeRegEx = '%(([^\d]|\s,){2}\s*|^)(?<phone>(?<country_code>' . cGeneratorRegEx::buildOrFromArray($this->_countryCode). ')?' . $this->_separator . "(?<provider>" . cGeneratorRegEx::buildOrFromArray($this->_settleCode) . ")?{$this->_separator}(?<1_number>\\d){$this->_separator}(?<2_number>\\d){$this->_separator}(?<3_number>\\d){$this->_separator}(?<4_number>\\d){$this->_separator}(?<5_number>\\d){$this->_separator}(?<6_number>\\d)?{$this->_separator}(?<7_number>\\d)?)(([^\\d]|\\s,){2}.*$|([^\\d]|\\s,\\.){0,3}$)%ims";
	}

	public function findMobile($text){
		$data = $this->parsingText($text, $this->mobileRegEx);
		return $data ? $this->buildNumber($data, 'phone', array('country_code', 'provider', '1_number', '2_number', '3_number', '4_number', '5_number', '6_number', '7_number')) : array();
	}

	public function findHome($text){
		$data = $this->parsingText($text, $this->homeRegEx);
		return $data ? $this->buildNumber($data, 'phone', array('country_code', 'provider', '1_number', '2_number', '3_number', '4_number', '5_number', '6_number', '7_number')) : array();

	}

	public function findPhone($text){
		$mobile = $this->findMobile($text);
		$home = $this->findHome($text);
		return array_merge($mobile,$home);
	}

	private function buildNumber($data, $rowName = 'phone', $pattern = array('country_code', 'provider', 'number')){
		$phones = array();
		foreach($data[$rowName] as $key => $value){
			if((!isset($data['country_code'][$key]) || !$data['country_code'][$key]) && isset($data['provider'][$key])){
				$data['country_code'][$key] = $this->getCountryCode($data['provider'][$key]);
			}
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

	private function getCountryCode($providerCode){
		foreach ($this->_mobileCode as $sign => $providers) {
			foreach($providers as $providerName => $providerCodes){
				if(in_array($providerCode, $providerCodes)){
					return $this->_countryCode[$sign];
				}
			}
		}
		return '';
	}

	public function hidePhone($text){

		$data = $this->parsingText($text, $this->mobileRegEx);
		if(isset($data['phone']) && $data['phone']){
			foreach($data['phone'] as $phone){
				$text = preg_replace('%(' . preg_quote($phone) . ')%msu', '', $text);
			}
		}

		$data = $this->parsingText($text, $this->homeRegEx);
		if(isset($data['phone']) && $data['phone']){
			foreach($data['phone'] as $phone){
				$text = preg_replace('%(' . preg_quote($phone) . ')%msu', '', $text);
			}
		}

		return $text;
	}
}