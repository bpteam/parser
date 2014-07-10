<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 06.03.14
 * Time: 9:18
 * Email: bpteam22@gmail.com
 */

namespace Parser;
use \GetContent\cSingleCurl as cSingleCurl;
use \GetContent\cMultiCurl as cMultiCurl;

class cParser {

	/**
	 * @var cMultiCurl
	 */
	public $multiCurl;
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

	function __construct(){
		$this->singleCurl = new cSingleCurl();
		$this->multiCurl  = new cMultiCurl();
		$this->catalog    = new cCatalog();
	}


	protected function loadContent($url, $checkRegEx = null){
		$checkRegEx = $checkRegEx?:$this->catalog->getConfig('site_page');
		if(is_string($url)){
			$answer = $this->singleCurl->load($url, $checkRegEx);
			$answer = array($answer);
		} elseif(is_array($url)){
			$answer = $this->multiCurl->load($url, $checkRegEx);
		} else {
			return false;
		}
		return $answer;
	}

	public function parsing($url){
		$this->parseCatalog($url);
		foreach($this->catalog->getUnits() as $unit){
			if($text = $this->loadContent($unit['unique'])){
				$this->parseAd($unit['unique'],current($text));
			}
		}
	}

	public function parseCatalog($url){
		do{
			$textList = $this->loadContent($url);
			foreach($textList as $text){
				$this->parseListAds($text);
				$url = $this->catalog->nextPage($text, $this->catalog->getConfig('pagination'), $this->catalog->getConfig('current_page'), $this->catalog->getConfig('pagination_parent'));
			}
		}while($url);
	}

	public function parseListAds($textList){
		$this->catalog->unitList($textList, $this->catalog->getConfig('list'), $this->catalog->getConfig('list_parent'));
	}

	public function parseAd($unique,$text){
		$this->catalog->unit($unique, $text, $this->catalog->getConfig('ad'), $this->catalog->getConfig('ad_parent'));
	}
} 