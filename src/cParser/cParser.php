<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 9:18
 * Email: bpteam22@gmail.com
 */

namespace Parser;
use \GetContent\cGetContent as cGetContent;

abstract class cParser {

	/**
	 * @var cGetContent |\GetContent\cSingleCurl
	 */
	public $single;
	/**
	 * @var cGetContent|\GetContent\cMultiCurl
	 */
	public $multi;
	/**
	 * @var cCatalog
	 */
	public $catalog;
	/**
	 * @var cPhone
	 */
	public $phone;
	/**
	 * @var cMoney
	 */
	public $money;
	/**
	 * @var cRealty
	 */
	public $realty;
	/**
	 * @var cCaptcha
	 */
	public $captcha;
	/**
	 * @var cCalendar
	 */
	public $calendar;

	public $blog;

	protected $_countDouble = 0;
	protected $_maxCountDouble = 15;

	protected $_mainDomain;

	public function getMainDomain(){
		return $this->_mainDomain;
	}

	public function setMainDomain($newVal){
		$this->_mainDomain = $newVal;
	}

	protected function parsMainDomain($url){
		$data = \GetContent\cStringWork::parseUrl($url);
		return $data['scheme'] . '://' . $data['host'];
	}

	function __construct(){
		$this->single  = new cGetContent('cSingleCurl');
		$this->multi   = new cGetContent('cMultiCurl');
		$this->catalog = new cCatalog();
	}

	protected function loadContent($url, $checkRegEx = null){
		$checkRegEx = $checkRegEx?:$this->catalog->getConfig('site_page');
		if(is_string($url)){
			$answer = $this->single->load($url, $checkRegEx);
			$answer = array('url' => $answer);
		} elseif(is_array($url)){
			$answer = $this->multi->load($url, $checkRegEx);
		} else {
			return false;
		}
		return $answer;
	}

	public function parsingSite($url){
		$this->parseCatalog($url);
		foreach($this->catalog->getUnits() as $unit){
			if($text = $this->loadContent($unit['unique'])){
				$this->parseAd($unit['unique'],current($text));
			}
		}
	}

	/**
	 * @param      $url
	 * @param int|bool $pageLevel max level to diving
	 */
	public function parseCatalog($url, $pageLevel = false){
		do{
			$textList = $this->loadContent($url);
			foreach($textList as $text){
				$this->parseListAds($text);
				$url = $this->catalog->nextPage($text, $this->catalog->getConfig('pagination'), $this->catalog->getConfig('current_page'), $this->catalog->getConfig('pagination_parent'));
			}
		}while($url && $this->isEndDiving($pageLevel));
	}

	public function parseListAds($textList){
		return $this->catalog->unitList($textList, $this->catalog->getConfig('list'), $this->catalog->getConfig('list_parent'));
	}

	public function parseAds($urls){
		$urls = is_array($urls) ? $urls : array($urls);
		foreach($urls as $url){
			$answer = $this->loadContent($url);
			foreach($answer as $text){
				$this->parseAd($url,$text);
			}
		}
	}

	public function parseAd($unique,$text){
		$this->catalog->unit($unique, $text, $this->catalog->getConfig('ad'), $this->catalog->getConfig('ad_parent'));
	}

	protected function isEndDiving($pageLevel){
		return $pageLevel && !($pageLevel < $this->catalog->getConfig('current_page'));
	}
} 