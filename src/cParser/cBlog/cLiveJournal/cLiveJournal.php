<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 13.03.14
 * Time: 9:46
 * Email: bpteam22@gmail.com
 */

namespace Parser;

require_once dirname(__FILE__) . "/../../../../../lib3/get_content/include.php";

class cLiveJournal extends cBlog {
	private $_journal;
	private $_articleTag;
	private $_commentPageCount = 0;
	private $_currentCommentPage = 1;
	/**
	 * @var \GetContent\cMultiCurl
	 */
	public $curl;

	/**
	 * @param string $journal
	 */
	public function setJournal($journal) {
		$this->_journal = $journal;
	}

	/**
	 * @return string
	 */
	public function getJournal() {
		return $this->_journal;
	}

	/**
	 * @param string $articleTag
	 */
	public function setArticleTag($articleTag) {
		$this->_articleTag = $articleTag;
	}

	/**
	 * @return string
	 */
	public function getArticleTag() {
		return $this->_articleTag;
	}




	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_postData = $this->loadConfig('post_data');
		$this->curl = new \GetContent\cMultiCurl();
	}

	public function getAllComments($page){
		$commentPages = $this->parsingText($page, $this->getConfig('comment_page'));
		$this->_commentPageCount = end($commentPages['comment_page']);
		$json = $this->parsingText($page, $this->getConfig('comments_json'));
		$json = current($json['comments_json']);
		$this->_comments = array();
		$this->_currentCommentPage = 1;
		do{
			$data = json_decode($json, true);
			$this->parsComments($data['comments']);
			$this->_currentCommentPage++;
			if($this->_currentCommentPage <= $this->_commentPageCount){
				$json = current($this->curl->load('http://'.$this->getJournal().'.livejournal.com/'.$this->getJournal().'/__rpc_get_thread?journal='.$this->getJournal().'&itemid='.$this->getArticleData('id').'&flat=&skip=&page='.$this->_currentCommentPage));
			} else {
				break;
			}
		}while(true);
	}

	private function parsComments($comments){
		foreach($comments as $comment){
			$this->getCommentTree($comment);
		}
	}

	protected function getCommentTree($data){
		$id = $data['dtalkid'];
		if(!$this->commentExist($id)){
			if($this->existHideComments($data)){
				$json = $this->curl->load('http://'.$this->getJournal().'.livejournal.com/'.$this->getJournal().'/__rpc_get_thread?journal='.$this->getJournal().'&itemid='.$this->getArticleData('id').'&thread='.$id.'&expand_all=1');
				$data = json_decode(current($json), true);
				$this->parsComments($data['comments']);
			} else {
				$this->_comments[$id]['author'] = $data['uname'];
				$this->_comments[$id]['avatar_url'] = $data['userpic'];
				$this->_comments[$id]['parent'] = $data['parent'];
				$this->_comments[$id]['subject'] = $data['subject'];
				$this->_comments[$id]['comment'] = $data['article'];
				$this->_comments[$id]['timestamp'] = $data['ctime_ts'];
			}
		}
	}

	private function existHideComments($data){
		return $data['leafclass'] == 'collapsed';
	}

	private function commentExist($id){
		return isset($this->_comments[$id]);
	}

	public function nextPage($page){
		$url = $this->parsingText($page, $this->getConfig('previous_url'));
		return isset($url['previous_url']) && $url['previous_url'][0] ? $url['previous_url'][0] : false;
	}

	public function findJournal($urlBlog){
		$journal = $this->parsingText($urlBlog, $this->getConfig('journal'));
		return isset($journal['journal']) && $journal['journal'][0] ? $journal['journal'][0] : false;
	}

	public function getRssUrlLJ($url){
		return preg_replace('%(.com)/?$%ims', '$1/data/rss',$url);
	}

	public function findArticleTag($urlBlog){
		$rss = current($this->curl->load($this->getRssUrlLJ($urlBlog)));
		$url = \GetContent\cStringWork::betweenTag($rss,"<guid isPermaLink='true'>");
		$article = \GetContent\cStringWork::betweenTag($rss,"<description>");
		$page = current($this->curl->load($url));
		$needText = mb_substr(htmlspecialchars_decode($article),0,99);
		if(preg_match('%(?<tag><[^>]+>)'.preg_quote($needText,'%').'%imsu', $page, $match)){
			$this->setArticleTag($match['tag']);
			return true;
		} else {
			return false;
		}

	}
} 