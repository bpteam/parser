<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 04.02.14
 * Time: 13:31
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cBlog extends cCatalog{

	protected $_article;
	protected $_comments;

	/**
	 * @param array $article
	 */
	public function setArticle($article) {
		$this->_article = $article;
	}

	/**
	 * @return array
	 */
	public function getArticle() {
		return $this->_article;
	}

	public function setArticleData($name,$value){
		$this->_article[$name] = $value;
	}

	public function getArticleData($name){
		return $this->_article[$name];
	}

	/**
	 * @param array $comments
	 */
	public function setComments($comments) {
		$this->_comments = $comments;
	}

	/**
	 * @return array
	 */
	public function getComments() {
		return $this->_comments;
	}

	function __construct(){
		$this->_classDir = dirname(__FILE__);
	}


	public function getTitle ($page){

	}

	public function getText ($page){

	}

	public function getAllComments($page){

	}

	protected function getCommentTree($page){

	}

	public function getAllCategory($page){

	}

	public function getAllTag($page){

	}

	public function getLinks($page){
		$data = $this->parsingText($page, $this->getConfig('list'));
		return array_unique($data['url']);

	}

	public function getPrevious($page){

	}

	public function download($url){

	}

	public function update(){

	}
} 