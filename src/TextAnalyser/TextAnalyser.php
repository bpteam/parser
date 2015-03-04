<?php
/**
 * Created by PhpStorm.
 * User: iEC
 * Date: 3/2/2015
 * Time: 9:29
 * Project: fo_realty
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

class TextAnalyser {

	private $countWords = 4;
	private $wordSeparator = '[\W_](?<![\.\-])';
	private $textBeginRegEx = '%(?:^|[\W_])(?<text>';
	private $textEndRegEx = ')(?:[\W_]|$)%u';
	private $wordRegEx = '[\w-]+';
	private $hiddenSymbolRegEx = '%([\W_]+(?<![\.\-]))%u';
	private $hiddenSymbol = ' ';
	private $tableName = 'wordTable';

	/**
	 * @return int
	 */
	public function getCountWords() {
		return $this->countWords;
	}

	/**
	 * @param int $countWords
	 */
	public function setCountWords($countWords) {
		$this->countWords = $countWords;
	}

	/**
	 * @return string
	 */
	public function getWordRegEx() {
		return $this->textBeginRegEx . $this->wordRegEx . $this->textEndRegEx;
	}

	public function getTextRegEx(){
		$wordsRegEx = [];
		for($i = 0; $i < $this->countWords; $i++)
			$wordsRegEx[] = $this->wordRegEx;
		return $this->textBeginRegEx . implode($this->wordSeparator,$wordsRegEx) . $this->textEndRegEx;
	}

	/**
	 * @param string $wordRegEx
	 */
	public function setWordRegEx($wordRegEx) {
		$this->wordRegEx = $wordRegEx;
	}

	/**
	 * @return string
	 */
	public function getHiddenSymbolRegEx() {
		return $this->hiddenSymbolRegEx;
	}

	/**
	 * @param string $hiddenSymbolRegEx
	 */
	public function setHiddenSymbolRegEx($hiddenSymbolRegEx) {
		$this->hiddenSymbolRegEx = $hiddenSymbolRegEx;
	}

	/**
	 * @return string
	 */
	public function getTableName() {
		return $this->tableName . $this->countWords;
	}

	/**
	 * @param string $tableName
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}
	/**
	 * @var mysqli
	 */
	private $mysqli;

	/**
	 * @return mysqli
	 */
	public function getMysqli() {
		return $this->mysqli;
	}

	/**
	 * @param mysqli $mysqli
	 */
	public function setMysqli($mysqli) {
		$this->mysqli = $mysqli;
	}

	/**
	 * @param mysqli $mysqli
	 */
	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}

	public function intiTable(){
		$tableName = $this->getTableName();
		$countChars = $this->countWords * 20;
		$sql = "DROP TABLE IF EXISTS `{$tableName}`;";
		$this->mysqli->query($sql);
		$sql = "CREATE TABLE `{$tableName}` (
			`id` INT NOT NULL AUTO_INCREMENT,
			`data` VARCHAR({$countChars}) NOT NULL,
			`count` int NOT NULL DEFAULT 1,
			PRIMARY KEY (`id`),
			UNIQUE INDEX `data_unique` (`data` ASC))
		ENGINE = InnoDB";
		return $this->mysqli->query($sql);
	}

	public function insert($text){
		$text = $this->mysqli->escape_string($text);
		$tableName = $this->getTableName();
		$sql = "INSERT INTO `{$tableName}` (`data`) VALUES('{$text}') ON DUPLICATE KEY UPDATE `count` = `count` + 1";
		return $this->mysqli->query($sql, MYSQLI_USE_RESULT);
	}

	public function analyseText($text){
		$text = preg_replace($this->hiddenSymbolRegEx, $this->hiddenSymbol, $text);
		$regEx = $this->getTextRegEx();
		$wordRegEx = $this->getWordRegEx();
		do{
			if(preg_match($regEx, $text, $match)){
				$this->insert($match['text']);
				$text = preg_replace($wordRegEx, '', $text, 1);
			} else {
				break;
			}
		}while(true);
	}

	/**
	 * @param int  $min min count
	 * @param int  $max max count
	 * @param bool|array $order [columnName => (true is ASC, false is DESC)]
	 * @param bool|string $fromTable
	 * @return array
	 */
	public function exportToArray($min = 1, $max = 999999, $order = false, $fromTable = false){
		if(!$fromTable){
			$fromTable = $this->getTableName();
		}
		$orderSQL = '';
		if($order && is_array($order)){
			$tmpOrder = [];
			foreach($order as $col => $sort){
				$tmpOrder[] =  $col . ' ' . ($sort?'ASC':'DESC');
			}
			$orderSQL = 'ORDER BY ' . implode(', ', $tmpOrder);
		}
		$returnData = [];
		$sql = "SELECT * FROM {$fromTable} WHERE count BETWEEN {$min} AND {$max} $orderSQL";
		if($result = $this->mysqli->query($sql)) {
			while ($data = $result->fetch_assoc()) {
				$returnData[$data['data']] = (float)$data['count'];
			}
			$result->free();
		}
		return $returnData;
	}


}