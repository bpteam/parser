<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 03.02.14
 * Time: 14:09
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cCatalog {

	/**
	 * @var array
	 */
	protected $_categories;
	protected $_units = array();
	protected $_currentPage = 1;
	protected $_classDir;
	protected $_configDir = 'config';
	protected $_config;
	protected $_defaultConfig;
	protected $_403RegEx = '%403 Forbidden%ims';
	protected $_404RegEx = '%404 Not Found%ims';

	/**
	 * @param string $name
	 * @param string $url
	 * @param string $parent
	 */
	public function setCategoryUrl($name, $url, $parent = '') {
		$this->_categories[$name]['url'] = $url;
		$this->_categories[$name]['parent'] = $parent;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function getCategoryUrl($name) {
		return $this->_categories[$name];
	}

	/**
	 * @return array
	 */
	public function getCategories(){
		return $this->_categories;
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
		return $this->_units?:array();
	}

	public function setUnit($name ,$unit){
		$this->_units[$name] = $unit;
	}

	public function addToUnit($name ,$unit){
			$this->_units[$name] = array_merge($this->getUnit($name), $unit);
	}

	public function getUnit($name){
		return isset($this->_units[$name]) ? $this->_units[$name] : array();
	}

	public function getUnitData($unitName, $paramName){
		return isset($this->_units[$unitName][$paramName]) ? $this->_units[$unitName][$paramName] : null;
	}

	/**
	 * @param int $currentPage
	 */
	public function setCurrentPage($currentPage) {
		$this->_currentPage = $currentPage;
	}

	/**
	 * @return int
	 */
	public function getCurrentPage() {
		return $this->_currentPage;
	}

	/**
	 * @param string $configDir
	 */
	public function setConfigDir($configDir) {
		$this->_configDir = $configDir;
	}

	/**
	 * @return string
	 */
	public function getConfigDir() {
		return $this->_configDir;
	}

	/**
	 * @param mixed $config
	 */
	public function setConfig($config) {
		$this->_config = $config;
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getConfig($name) {
		if(isset($this->_config[$name])){
			$config = $this->_config[$name];
		} elseif(isset($this->_defaultConfig[$name])){
			$config = $this->_defaultConfig[$name];
		} else {
			$config = false;
		}
		return $config;
	}

	/**
	 * @param string $classDir
	 */
	public function setClassDir($classDir) {
		$this->_classDir = $classDir;
	}

	/**
	 * @return string
	 */
	public function getClassDir() {
		return $this->_classDir;
	}



	public function set403RegEx($regEx){
		$this->_403RegEx = $regEx;
	}

	public function get403RegEx(){
		return $this->_403RegEx;
	}

	public function set404RegEx($regEx){
		$this->_404RegEx = $regEx;
	}

	public function get404RegEx(){
		return $this->_404RegEx;
	}

	function __construct() {
		$this->_classDir = dirname(__FILE__);
		$this->loadDefaultConfig();
	}


	public function loadConfig($name){
		$this->_config = require $this->_classDir . DIRECTORY_SEPARATOR . ($this->_configDir ? $this->_configDir . DIRECTORY_SEPARATOR : '') . $name . '.php';
		return $this->_config;
	}
	protected function loadDefaultConfig(){
		$this->_config = require $this->_classDir . DIRECTORY_SEPARATOR . ($this->_configDir ? $this->_configDir . DIRECTORY_SEPARATOR : '') . 'regExDefault.php';
		return $this->_config;
	}

	/**
	 * @param string $text
	 * @param string $parent
	 * @param string $regEx
	 * @param string $parentRegEx
	 * @return bool
	 */
	public function categories($text, $parent = '', $regEx = '%<a[^>]*href=[\'"](?<url>[^"]*)[\'"][^>]*>(?<name>[<]*)</a>%ims', $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		if($result){
			foreach ($result['url'] as $key => $value) {
				$this->setCategoryUrl($result['name'][$key], $value, $parent);
			}
		}
		return false;
	}

	/**
	 * @param        $text
	 * @param string $regEx
	 * @param string $parentRegEx
	 * @return bool
	 */
	public function unitList($text, $regEx = '%<a[^>]*href=[\'"](?<unique>[^"]*)[\'"][^>]*><img src=[\'"](?<param_one>[^\'"]*)[\'"]>(?<param_n>.*)</a>%ims', $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		if($result){
			foreach($this->grouping('unique', $result) as $uniqueName => $unit){
				$this->setUnit($uniqueName, $unit);
			}
			return true;
		}
		return false;
	}

	/**
	 * @param string        $unitName
	 * @param string        $text
	 * @param array|string  $regEx
	 * @param string        $parentRegEx
	 * @return bool
	 */
	public function unit($unitName, $text, $regEx = array('%(?<param_one><a[^>]+>)%ims', '%(?<param_n><div>[^<]+</div>)%ims'), $parentRegEx = '%(?<text>.*)%ims'){
		$result = $this->parsingText($text, $regEx, $parentRegEx);
		if($result){
			$this->addToUnit($unitName, $result);
			return true;
		}
		return false;
	}

	public function pagination($text, $regEx = '%<a href="(?<url>/page/(?<num>\d+))">%ims', $currentPage = '%<span\s*id="current">(?<current_page>\d+)</a>%', $parentRegEx = '%(?<text>.*)%ims'){
		$result  = $this->parsingText($text, $regEx, $parentRegEx);
		$pages = array();
		if(isset($result['num'])){
			$current = $this->parsingText($text, $currentPage, $parentRegEx);
			$this->setCurrentPage(isset($current['current_page'])?$current['current_page'][0]:1);
			$result['num'] = array_unique($result['num']);
			asort($result['num']);
			foreach($result['num'] as $key => $value){
				$pages[$value] = $result['url'][$key];
			}
		}
		return $pages;
	}

	public function nextPage( $text, $regEx = '%<a href="(?<url>/page/(?<num>\d+))">%ims', $currentPage = '%<span\s*id="current">(?<current_page>\d+)</a>%', $parentRegEx = '%(?<text>.*)%ims'){
		$pages = $this->pagination($text, $regEx, $currentPage, $parentRegEx);
		$this->setCurrentPage($this->getCurrentPage() + 1);
		return isset($pages[$this->getCurrentPage()]) ? $pages[$this->getCurrentPage()] : false;
	}

	public function generatePaginationLinks($text, $regEx = '%<a href="(?<url>(?<url_start>.*/page/)(?<num>\d+)(?<url_end>.*))">%ims', $regExTotalPages = '%(?<url>.*/page/)(?<total_pages>last)">%ims', $start = 1, $end = 0, $parentRegEx = '%(?<text>.*)%ims'){
		$resultPagination = $this->parsingText($text, $regEx, $parentRegEx);
		$resultTotalPages = $this->parsingText($text, $regExTotalPages, $parentRegEx);
		$urlOfList = array();
		if(!isset($resultTotalPages['total_pages'][0])){
			$resultTotalPages['total_pages'][0] = 1;
		}
		if($end > $resultTotalPages['total_pages'][0] || !$end){
			$end = $resultTotalPages['total_pages'][0];
		}
		if($start < $resultTotalPages['total_pages'][0] && $resultPagination){
			for( ; $start<=$end; $start++){
				$urlOfList[$start] = $resultPagination['url_start'][0] . $start . $resultPagination['url_end'][0];
			}
		}
		return $urlOfList;
	}

	public function parsingText($text, $mainRegEx, $parentRegEx = '%(?<text>.*)%ims'){
		if(!is_array($mainRegEx)){
			$mainRegEx = array($mainRegEx);
		}
		if(preg_match($parentRegEx, $text, $match)){
			$data = array();
			foreach($mainRegEx as $regEx){
				if(is_array($regEx)){
					$data = $this->parsingText($match['text'],$regEx);
				}elseif(preg_match_all($regEx, $match['text'], $matches)){
					$data = array_merge($data, $matches);
				}
			}
			foreach($data as $key => $value){
				if(preg_match('%^\d+$%ms', $key)){
					unset($data[$key]);
				}
			}
			return $data?:array();
		}
		return array();
	}

	protected function grouping($uniqueRow, $data){
		if(isset($data[$uniqueRow])){
			$groupData = array();
			foreach ($data[$uniqueRow] as $uniqueKey => $uniqueValue) {
				$unit = array();
				foreach(array_keys($data) as $row){
					$unit[$row] = trim($data[$row][$uniqueKey]);
				}
				$groupData[$unit[$uniqueRow]] = $unit;
			}
			return $groupData;
		}
		return array();
	}

	public function is404($text){
		return preg_match($this->_config['404'], $text);
	}
} 