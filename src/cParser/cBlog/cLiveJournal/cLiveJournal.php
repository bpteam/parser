<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 13.03.14
 * Time: 9:46
 * Email: bpteam22@gmail.com
 */

namespace Parser;

require_once dirname(__FILE__) . "/../../../../../loader-curl-phantomjs-proxy/include.php";

class cLiveJournal extends cBlog {
	private $_journal = '';
	private $_articleBlock = '';
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
	 * @param string $articleBlock
	 */
	public function setArticleBlock($articleBlock) {
		$this->_articleBlock = $articleBlock;
	}

	/**
	 * @return string
	 */
	public function getArticleBlock() {
		return $this->_articleBlock;
	}

	/**
	 * @param array $tag
	 */
	public function setTag($tag) {
		$this->_tag = $tag;
	}

	/**
	 * @return array
	 */
	public function getTag() {
		return $this->_tag;
	}




	function __construct(){
		$this->_classDir = dirname(__FILE__);
		$this->_postData = $this->loadConfig('post_data');
		$this->curl = new \GetContent\cMultiCurl();
	}

	public function init($url){
		$this->setJournal($this->getJournalInUrl($url));
		$this->findArticleBlock($this->getJournal());
	}

	public function parsArticle($page){
		$this->clearArticle();
		$this->setAuthorNic($this->getArticleAuthorNic($page));
		$this->setAuthorId($this->getArticleAuthorId($page));
		$this->setPostId($this->getArticleId($page));
		$this->setTitle($this->getArticleTitle($page));
		$this->setPost($this->getArticleText($page));
		$this->setTag($this->getArticleTag($page));
		$this->getArticleComments($page);
	}

	public function getArticleComments($page){
		$commentPages = $this->parsingText($page, $this->getConfig('comment_page'));
		$this->_commentPageCount = end($commentPages['comment_page']);
		$json = $this->parsingText($page, $this->getConfig('comments_json'));
		$json = current($json['comments_json']);
		$this->_currentCommentPage = 1;
		do{
			$data = json_decode($json, true);
			$this->parsComments($data['comments']);
			$this->_currentCommentPage++;
			if($this->_currentCommentPage <= $this->_commentPageCount){
				$json = current($this->curl->load('http://'.$this->getJournal().'.livejournal.com/'.$this->getJournal().'/__rpc_get_thread?journal='.$this->getJournal().'&itemid='.$this->getPostId().'&flat=&skip=&page='.$this->_currentCommentPage));
			} else {
				break;
			}
		}while(true);
	}

	private function parsComments($comments){
		foreach($comments as $comment){
			if(isset($comment['dtalkid'])){
				$this->getCommentTree($comment);
			}
		}
	}

	protected function getCommentTree($data){
		$id = $data['dtalkid'];
		if(!$this->commentExist($id)){
			if($this->existHideComments($data)){
				$json = $this->curl->load('http://'.$this->getJournal().'.livejournal.com/'.$this->getJournal().'/__rpc_get_thread?journal='.$this->getJournal().'&itemid='.$this->getPostId().'&thread='.$id.'&expand_all=1');
				$data = json_decode(current($json), true);
				$this->parsComments($data['comments']);
			} else {
				$this->_comments[$id]['author'] = $data['uname'];
				$this->_comments[$id]['avatar_url'] = isset($data['userpic'])?$data['userpic']:'';
				$this->_comments[$id]['parent'] = isset($data['parent'])?$data['parent']:null;
				$this->_comments[$id]['subject'] = $data['subject'];
				$this->_comments[$id]['comment'] = $data['article'];
				$this->_comments[$id]['timestamp'] = $data['ctime_ts'];
			}
		}
	}

	private function existHideComments($data){
		return isset($data['leafclass']) && $data['leafclass'] == 'collapsed';
	}

	private function commentExist($id){
		return isset($this->_comments[$id]);
	}

	public function nextPage($page){
		preg_match_all($this->getConfig('previous_url'), $page, $url);
		return isset($url['previous_url']) && $url['previous_url'][0] ? $url['previous_url'][0] : false;
	}

	public function getArticleAuthorNic($page){
		if(preg_match($this->getConfig('user_nic'), $page, $match)){
			$json = json_decode( $match['user_nic'], true);
			return $json['username'];
		} else {
			return false;
		}
	}

	public function getArticleAuthorId($page){
		if(preg_match($this->getConfig('user_nic'), $page, $match)){
			$json = json_decode( $match['user_nic'], true);
			return $json['id'];
		} else {
			return false;
		}
	}

	public function getArticleTitle($page){
		if(preg_match($this->getConfig('title_json'), $page, $match)){
			$json = json_decode( $match['title_json'], true);
			return $json['title'];
		} else {
			return false;
		}
	}

	public function getArticleId($page){
		if(preg_match($this->getConfig('title_json'), $page, $match)){
			$json = json_decode( $match['title_json'], true);
			return $json['ditemid'];
		} else {
			return false;
		}
	}

	public function getArticleJournal($page){
		if(preg_match($this->getConfig('title_json'), $page, $match)){
			$json = json_decode( $match['title_json'], true);
			return $json['journal'];
		} else {
			return false;
		}
	}

	public function getArticleText ($page){
		return \GetContent\cStringWork::betweenTag($page, $this->getArticleBlock());
	}

	public function getJournalInUrl($urlBlog){
		$journal = $this->parsingText($urlBlog, $this->getConfig('journal'));
		return isset($journal['journal']) && $journal['journal'][0] ? $journal['journal'][0] : false;
	}

	public function getRssUrl($journalName){
		return 'http://'.$journalName.'.livejournal.com/data/rss';
	}

	public function findArticleBlock($journalName){
		$rss = current($this->curl->load($this->getRssUrl($journalName)));
		do{
			$count = 0;
			$item = \GetContent\cStringWork::betweenTag($rss,"<item>");
			$rss = preg_replace('%(<item>)%imsu','',$rss,1,$count);
			$url = \GetContent\cStringWork::betweenTag($item,"<guid isPermaLink='true'>");
			$rss = preg_replace('%(<guid\s*isPermaLink=\'true\'>)%ims','',$rss,1,$count);
			if(!$item || !$url){
				break;
			}
			$article = \GetContent\cStringWork::betweenTag($item,"<description>");
			$page = current($this->curl->load($url));
			$needText = mb_substr(htmlspecialchars_decode($article),0,99,"UTF-8");
			$needText = str_replace('&apos;', "'", $needText);
			$regEx = '%(?<tag><[^>]+>)\s*'.preg_quote($needText,'%').'%imsu';
			if(preg_match($regEx, $page, $match)){
				$this->setArticleBlock($match['tag']);
				return true;
			}
		}while(true);

		return false;
	}

	public function getLinks($page){
		$data = $this->parsingText($page, $this->getConfig('list'));
		foreach($data['journal'] as $key => $value){
			if($value != $this->getJournal()){
				unset($data['url'][$key]);
			}
		}
		return array_unique($data['url']);
	}

	private function clearArticle(){
		$this->setPostId(0);
		$this->setAuthorNic('');
		$this->setAuthorId(null);
		$this->setTitle('');
		$this->setPost('');
		$this->setTag(array());
		$this->setComments(array());
	}
} 