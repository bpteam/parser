<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 13.03.14
 * Time: 9:46
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cLiveJournal extends cBlog {
	private $_postData;

	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_postData = $this->loadConfig('post_data');
	}

	public function getComments($page){
		$json = $this->parsingText($page, $this->getConfig('comments_json'));
		$data = json_decode($json, true);
		foreach($data['comments'] as $topComment){

		}
	}

} 