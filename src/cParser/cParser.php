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

	protected $_countDouble = 0;
	protected $_maxCountDouble = 15;

	function __construct(){
		$this->singleCurl = new cSingleCurl();
		$this->multiCurl  = new cMultiCurl();
		$this->catalog    = new cCatalog();
	}


	protected function loadContent($url){
		if(is_string($url)){
			$answer = $this->singleCurl->load($url);
			$answer = array($answer);
		} elseif(is_array($url)){
			$answer = $this->multiCurl->load($url);
		} else {
			return false;
		}
		return $answer;
	}

	public function parsCategory($url){

	}

	public function parsCatalog($url){
		do{
			$textList = $this->loadContent($url);
			foreach($textList as $text){
				$this->parsListAds($text);
				$url = $this->catalog->nextPage($text, $this->catalog->getConfig('pagination'), $this->catalog->getConfig('current'), $this->catalog->getConfig('pagination_parent'));
			}
		}while($url);
	}

	public function parsListAds($textList){
		$this->catalog->unitList($textList, $this->catalog->getConfig('list'), $this->catalog->getConfig('list_parent'));
		foreach($this->catalog->getUnits() as $unit){
			if($text = $this->loadContent($unit['unique'])){
				$this->parsAd($unit,$text);
			}
		}
	}

	public function parsAd($unit,$text){
		$this->catalog->unit($unit['unique'], $text, $this->catalog->getConfig('ad'), $this->catalog->getConfig('ad_parent'));
	}
} 