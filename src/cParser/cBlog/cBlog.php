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

	protected $_article = '';
	protected $_title = '';
	protected $_tag;
	protected $_id;
	protected $_comments = array();

	/**
	 * @param string $article
	 */
	public function setArticle($article) {
		$this->_article = $article;
	}

	/**
	 * @return string
	 */
	public function getArticle() {
		return $this->_article;
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

	/**
	 * @param mixed $id
	 */
	public function setId($id) {
		$this->_id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->_title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->_title;
	}



	function __construct(){
		$this->_classDir = dirname(__FILE__);
	}

	public function init($url){

	}

	public function parsArticle($page){

	}

	public function getArticleTitle ($page){

	}

	public function getArticleText ($page){

	}

	public function getArticleComments($page){

	}

	protected function getCommentTree($page){

	}

	public function getArticleCategory($page){

	}

	public function getArticleTag($page){
		$data = $this->parsingText($page, $this->getConfig('tag'));
		return array_unique($data['tag']);
	}

	public function getLinks($page){
		$data = $this->parsingText($page, $this->getConfig('list'));
		return array_unique($data['url']);
	}

	public function getPrevious($page){

	}
} 