<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 14.07.14
 * Time: 16:45
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cMultiParser extends cParser {

	protected $countStream = 50;

	/**
	 * @return int
	 */
	public function getCountStream() {
		return $this->countStream;
	}

	/**
	 * @param int $countStream
	 */
	public function setCountStream($countStream) {
		$this->countStream = $countStream;
	}

	function __construct(){
		parent::__construct();
	}

	public function parsingSite($url){
		$this->parseCatalog($url);
		foreach(array_chunk($this->catalog->getUnits(), $this->countStream) as $units){
			$url = array();
			foreach($units as $unit){
				$url[] = $unit['unique'];
			}
			$answer = $this->loadContent($url);
			if($answer){
				foreach($answer as $key => $data){
					$this->parseAd($url[$key],$data);
				}
			}
		}
	}

	public function parseCatalog($url){
		$textList = $this->loadContent($url);
		foreach($textList as $text){
			$urlOfList = $this->catalog->generatePaginationLinks($text, $this->catalog->getConfig('pagination'), $this->catalog->getConfig('total_pages'), 1, 0, $this->catalog->getConfig('pagination_parent'));
			if($urlOfList){
				foreach(array_chunk($urlOfList, $this->countStream) as $urls){
					$pageLists = $this->loadContent($urls);
					foreach($pageLists as $pageKey => $page){
						if(!$this->parseListAds($page)){
							\cSupport::inLog('error parse list ' . $urls[$pageKey] . ' in ' . $page);
						}
					}
				}
			} else {
				$this->parseListAds($text);
			}
		}
	}

	public function parsAds($allUrls){
		$allUrls = is_array($allUrls) ? $allUrls : array($allUrls);
		foreach(array_chunk($allUrls, $this->countStream) as $urls){
			$answer = $this->loadContent($urls);
			foreach($answer as $key => $text){
				$this->parseAd($urls[$key],$text);
			}
		}
	}
}