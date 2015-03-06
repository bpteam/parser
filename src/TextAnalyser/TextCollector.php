<?php
/**
 * Created by PhpStorm.
 * User: iEC
 * Date: 3/4/2015
 * Time: 22:32
 * Project: fo_realty
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

class TextCollector extends TextAnalyser{

	protected $tableName = 'textPatterns';

	/**
	 * @var mysqli
	 */
	protected $mysqli;

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

	public function explodeText($text){
		foreach(parent::explodeText($text) as $pattern)
			$this->insert($pattern);
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