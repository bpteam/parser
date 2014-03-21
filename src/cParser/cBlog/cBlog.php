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

	protected $_post = '';
	protected $_title = '';
	protected $_tag;
	protected $_authorId;
	protected $_authorNic;
	protected $_postId;
	protected $_comments = array();

	/**
	 * @param mixed $authorNic
	 */
	public function setAuthorNic($authorNic) {
		$this->_authorNic = $authorNic;
	}

	/**
	 * @return mixed
	 */
	public function getAuthorNic() {
		return $this->_authorNic;
	}

	/**
	 * @param mixed $authorId
	 */
	public function setAuthorId($authorId) {
		$this->_authorId = $authorId;
	}

	/**
	 * @return mixed
	 */
	public function getAuthorId() {
		return $this->_authorId;
	}

	/**
	 * @param mixed $tag
	 */
	public function setTag($tag) {
		$this->_tag = $tag;
	}

	/**
	 * @return mixed
	 */
	public function getTag() {
		return $this->_tag;
	}

	/**
	 * @param string $post
	 */
	public function setPost($post) {
		$this->_post = $post;
	}

	/**
	 * @return string
	 */
	public function getPost() {
		return $this->_post;
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
	public function setPostId($id) {
		$this->_postId = $id;
	}

	/**
	 * @return mixed
	 */
	public function getPostId() {
		return $this->_postId;
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