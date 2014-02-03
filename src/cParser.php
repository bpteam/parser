<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 03.02.14
 * Time: 14:09
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cParser {

	/**
	 * @var array
	 */
	private $_category;
	private $_units;

	/**
	 * @param string $name
	 * @param string $url
	 */
	public function setCategory($name, $url) {
		$this->_category[$name] = $url;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function getCategoryUrl($name) {
		return $this->_category[$name];
	}

	/**
	 * @return array
	 */
	public function getCategories(){
		return $this->_category;
	}

	/**
	 * @param array $units
	 */
	public function setUnits($units) {
		$this->_units = $units;
	}

	/**
	 * @return array
	 */
	public function getUnits() {
		return $this->_units;
	}

	public function addUnit($name ,$unit){
		$this->_units[$name] = $unit;
	}

	public function getUnit($name){
		return $this->_units[$name];
	}

	/**
	 * @param string $text
	 * @param string $regEx
	 * @param string $parentRegEx
	 * @return bool
	 */
	public function category($text, $regEx = '%<a[^>]*href=[\'"](?<url>[^"]*)[\'"][^>]*>(?<name>[<]*)</a>%ims', $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		if($result){
			foreach ($result['url'] as $key => $value) {
				$this->setCategory($result['name'][$key], $value);
			}
		}
		return false;
	}

	public function catalog($text, $regEx = '%<a[^>]*href=[\'"](?<unique>[^"]*)[\'"][^>]*><img src=[\'"](?<param_one>[^\'"]*)[\'"]>(?<param_n>.*)</a>%ims', $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		if($result){
			foreach($this->grouping('unique', $result) as $uniqueName => $unit){
				$this->addUnit($uniqueName, $unit);
			}
			return true;
		}
		return false;
	}

	public function unit($unitName, $text, $regEx = array('%(?<param_one><a[^>]+>)%ims', '%(?<param_n><div>[^<]+</div>)%ims'), $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		if($result){
			$this->addUnit($unitName, array_merge($this->getUnit($unitName), $result));
			return true;
		}
		return false;
	}

	public function pagination($text, $regEx = '%<a href="(?<url>/page/(?<num>\d+))">%ims', $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		$pages = array();
		foreach($result['url'] as $key => $value){
			$pages[$result['num'][$key]] = $value;
		}
		return $pages;
	}

	public function nextPage($currentPage, $text, $regEx = '%<a href="(?<url>/page/(?<num>\d+))">%ims', $parentRegEx = '%(?<text>.*)%ims'){
		$pages = $this->pagination($text, $regEx, $parentRegEx);
		return isset($pages[$currentPage+1]) ? $pages[$currentPage+1] : false;
	}

	private function parsingText($text, $mainRegEx, $parentRegEx){
		if(!is_array($mainRegEx)){
			$mainRegEx = array($mainRegEx);
		}
		if(preg_match($parentRegEx, $text, $match)){
			$data = array();
			foreach($mainRegEx as $regEx){
				if(preg_match_all($regEx, $match['text'], $matches)){
					$data = array_merge($data, $matches);
				}
			}
			foreach($data as $key => $value){
				if(preg_match('%^\d+$%ms', $key)){
					unset($data[$key]);
				}
			}
			return count($data) ? $data : array();
		}
		return array();
	}

	private function grouping($uniqueRow, $data){
		if(isset($data[$uniqueRow])){
			foreach ($data[$uniqueRow] as $uniqueKey => $uniqueValue) {
				$unit = array();
				foreach(array_keys($data) as $row){
					$unit[$row] = $data[$row][$uniqueKey];
				}
				$data[$unit[$uniqueRow]] = $unit;
			}
			return $data;
		}
		return array();
	}
} 