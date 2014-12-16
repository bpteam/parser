<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 17.02.14
 * Time: 9:55
 * Email: bpteam22@gmail.com
 */

namespace Parser;


class cYandexCaptcha extends cCaptcha {

public function getQuery($form){
	$data['action'] = $form['form_action'];
	$data['referer'] = $form['form_referer'];
	$data['get'] = 'key='.$form['key'].'&retpath='.$form['retpath'].'&response='.$form['captcha'];
	return $data;
}

public function isCaptcha($text){
	return preg_match('%/captcha/check\-captcha\.xml%ims', $text);
}

public function getFormData($text){
	$formRegEx = array(
		'%<form[^>]*method="(?<form_method>[^"]*)"[^>]*action="(?<form_action>[^"]*)"[^>]*>%ims',
		'%<input[^>]*type="hidden"[^>]*name="key"[^>]*value="(?<key>[^"]*)"[^>]*>%ims',
		'%<input[^>]*type="hidden"[^>]*name="retpath"[^>]*value="(?<retpath>[^"]*)"[^>]*>%ims',
		'%<img[^>]*src="(?<img>http://\w*[^"]*captcha[^"]*)"[^>]*>%ims',
	);
	$this->unit($this->unitName, $text, $formRegEx);
}

}