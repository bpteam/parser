<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 10.02.14
 * Time: 10:18
 * Email: bpteam22@gmail.com
 */

namespace Parser;


use GetContent\cStringWork;

class cPhone extends cCatalog{
	private $_countryCode;
	private $_settleCode;
	private $_mobileCode;
	private $_separator = '(?:\(|\)|\-|\_|\[|\]|\s+){0,3}';
	private $_codeSeparator = '(?:\D)?';

	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_countryCode = $this->loadConfig('country_code');
		$this->_mobileCode = $this->loadConfig('mobile_code');
		$this->_settleCode = $this->loadConfig('settle_code');
		$mobile = array(
			'%(?<phone>',
			'(?<country_code>' . cGeneratorRegEx::buildOrFromArray(cGeneratorRegEx::buildSeparatorArrayString($this->_countryCode, $this->_codeSeparator)) . ')?',
			'(?<provider>' . cGeneratorRegEx::buildOrFromArray(cGeneratorRegEx::buildSeparatorArrayString($this->_mobileCode, $this->_codeSeparator)) . ')',
			'(?<1_number>\d)',
			'(?<2_number>\d)',
			'(?<3_number>\d)',
			'(?<4_number>\d)',
			'(?<5_number>\d)',
			'(?<6_number>\d)',
			'(?<7_number>\d)',
			')%ims',
		);
		$home = array(
			'%(([^\d]|\s,){2}\s*|^)',
			'(?<phone>(?<country_code>' . cGeneratorRegEx::buildOrFromArray(cGeneratorRegEx::buildSeparatorArrayString($this->_countryCode, $this->_codeSeparator)). ')?',
			'(?<provider>' . cGeneratorRegEx::buildOrFromArray(cGeneratorRegEx::buildSeparatorArrayString($this->_settleCode, $this->_codeSeparator)) . ')?',
			'(?<1_number>\d)',
			'(?<2_number>\d)',
			'(?<3_number>\d)',
			'(?<4_number>\d)',
			'(?<5_number>\d)',
			'(?<6_number>\d)?',
			'(?<7_number>\d)?)',
			'(([^\\d]|\\s,){2}.*$|([^\\d]|\\s,\\.){0,3}$)%ims',
		);
		$this->mobileRegEx = cGeneratorRegEx::buildSeparatorArray($mobile, $this->_separator);
		$this->homeRegEx = cGeneratorRegEx::buildSeparatorArray($home, $this->_separator);
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
			$phones[] = cStringWork::clearNote($phone,'%\D%','');
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

	public function hidePhone($text, $replaceChar = '', $countNumbers = 5){
		$text = $this->hideMobile($text, $replaceChar, $countNumbers);
		$text = $this->hideHome($text, $replaceChar, $countNumbers);
		return $text;
	}

	public function hideMobile($text, $replaceChar = '', $countNumbers = 7){
		$replaceChar = str_pad($replaceChar,$countNumbers, $replaceChar);
		$countNumbers = $countNumbers - ($countNumbers * 2);
		$data = $this->parsingText($text, $this->mobileRegEx);
		if(isset($data['phone']) && $data['phone']){
			foreach($data['phone'] as $phone){
				$text = preg_replace('%(' . preg_quote(substr($phone, $countNumbers)) . ')%msu', $replaceChar, $text);
			}
		}
		return $text;
	}

	public function hideHome($text, $replaceChar = '', $countNumbers = 5){
		$replaceChar = str_pad($replaceChar,$countNumbers, $replaceChar);
		$countNumbers = $countNumbers - ($countNumbers * 2);
		$data = $this->parsingText($text, $this->homeRegEx);
		if(isset($data['phone']) && $data['phone']){
			foreach($data['phone'] as $phone){
				$text = preg_replace('%(' . preg_quote(substr($phone, $countNumbers)) . ')%msu', $replaceChar, $text);
			}
		}
		return $text;
	}
}