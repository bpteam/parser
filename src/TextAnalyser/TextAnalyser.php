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

	protected $countWords = 4;
	protected $wordSeparator = '[\W_](?<![\.\-])';
	protected $textBeginRegEx = '%(?:^|[\W_](?<![\.\-]))(?<text>';
	protected $textEndRegEx = ')(?:[\W_](?<![\.\-\'])|$)%u';
	protected $wordRegEx = '[\w\-\.]+';
	protected $hiddenSymbolRegEx = '%([\W_]+(?<![\.\-]))%u';
	protected $hiddenSymbol = ' ';
	protected $maxPercentDiff = 15;

	protected $text;
	protected $explodedText = [];

	protected $costIns = 1;
	protected $costRep = 1;
	protected $costDel = 1;

	public function setMaxPercentDiff($newVal){
		$this->maxPercentDiff = $newVal;
	}

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
		return '%' . $this->wordRegEx . '%u';
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

	public function hideSymbols(&$text){
		$text = preg_replace($this->hiddenSymbolRegEx, $this->hiddenSymbol, $text);
	}



	public function explodeText($text){
		$this->hideSymbols($text);
		$regEx = $this->getTextRegEx();
		$wordRegEx = $this->getWordRegEx();
		$patterns = [];
		do{
			if(preg_match($regEx, $text, $match)){
				$patterns[] = $match['text'];
				$text = preg_replace($wordRegEx, '', $text, 1);
			} else {
				break;
			}
		}while(true);
		return $patterns;
	}

	public function countWordsInText($text){
		$this->hideSymbols($text);
		return preg_match_all($this->getWordRegEx(),$text);
	}

	public function analyseText($text, $patterns){
		$this->text = $text;
		$this->hideSymbols($this->text);
		$bestDiff = 101;
		$bestTarget = null;
		$bestText = null;
		foreach($patterns as $pattern => $target){
			$this->analyseTextPart($pattern, $target, $bestText, $bestTarget, $bestDiff);
		}
		return ['text' => $bestText, 'target' => $bestTarget, 'diff' => $bestDiff];
	}

	public function analyseTextPart($pattern, $target, &$bestText, &$bestTarget, &$bestDiff){
		$this->hideSymbols($pattern);
		$patternStrlen = strlen($pattern);
		$countWords = $this->countWordsInText($pattern);
		if(!isset($explodedText[$countWords])){
			$this->setCountWords($countWords);
			$this->explodedText[$countWords] = $this->explodeText($this->text);
		}
		foreach($this->explodedText[$countWords] as $textPart){
			$levenshtein = levenshtein($textPart, $pattern, $this->costIns, $this->costRep, $this->costDel);
			$percentDiff = $levenshtein * 100 / $patternStrlen;
			if($this->maxPercentDiff >= $percentDiff && $bestDiff > $percentDiff){
				$bestText = $textPart;
				$bestTarget = $target;
				$bestDiff = $percentDiff;
				if($percentDiff === 0)
					break;
			}
		}
	}

	/**
	 * Анализ адрусов которые состоят из нескольких шаблонов
	 * @param string $text
	 * @param array $pattern [[pattern0 => target0], [pattern1 => target1]]
	 */
	public function compositeAnalyseText($text, $pattern){

	}


}