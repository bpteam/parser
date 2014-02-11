<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 04.02.14
 * Time: 16:55
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cGeneratorRegEx {

	static function fromHtmlTag($tag){
		$replaceData = array(
			'%["\']%ms' => '["\']?',
			'%\s+%ms' => '\s*',
			'%>%ms' => '[^>]*>\s*',
			'%<(\w+)%ms' => '\s*<$1[^>]*',
			'%=%ms' => '\s*=\s*',
		);
		foreach ($replaceData as $regEx => $replace) {
			$tag = preg_replace($regEx, $replace, $tag);
		}
		return $tag;
	}

	static function allLetter($text){
		preg_match_all('%(?<symbol>.)%', $text, $match);
		$regEx = '';
		foreach($match['symbol'] as $symbol){
			$regEx .= '(' . mb_strtoupper($symbol). '|' . mb_strtolower($symbol) . ')';
		}
		return $regEx;
	}

	static function buildOrFromArray($data, &$recursiveData = array()){
		if(is_array($data)){
			foreach($data as $value){
				if(is_array($value)){
					self::buildOrFromArray($value, $recursiveData);
				} else {
					$recursiveData[] = $value;
				}
			}
		}
		$or = '('.implode('|',array_unique($recursiveData)).')';
		return strlen($or)>3 ? $or : '' ;
	}
} 