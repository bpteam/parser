<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 17.02.14
 * Time: 9:39
 * Email: bpteam22@gmail.com
 */

namespace Parser;


abstract class cCaptcha extends cCatalog {

	protected $unitName = 'captcha';
	protected $get;
	protected $post;
	protected $img;

public function getData(){
	return $this->getUnit($this->unitName);
}

protected abstract function getFormData($text);
} 