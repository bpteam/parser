<?php
/**
 * Created by PhpStorm.
 * User: EC_l
 * Date: 17.02.14
 * Time: 11:07
 * Email: bpteam22@gmail.com
 */
require_once dirname(__FILE__) . '/../../loader/include.php';
$gc = new \GetContent\cGetContent();
$gc->setMode('phantom');
$yandex = new \Parser\cYandexCaptcha();
$gc->setKey('testYandexCaptcha_'.date('Y-m-d'));
if(isset($_POST['load_captcha'])){

	$url = "http://market.yandex.ua/guru.xml?CMD=-RR=9,0,0,0-PF=1801946~EQ~sel~1871375-VIS=8070-CAT_ID=160043-EXC=1-PG=10&hid=91491";
	$gc->setMode('phantom');
	$text = $gc->getContent($url);
	if($yandex->isCaptcha($text)){
		$yandex->getFormData($text);
		$data = $yandex->getData();
	} else {
		echo "<h1>NO CAPTCHA</h1>";
		echo $text;
		exit;
	}
} else {
	$query = $yandex->getQuery($_POST);
	$text = $gc->getContent($query . '?' . $query['get']);
	echo "<h1>-CAPTCHA SEND-</h1>";
	if($yandex->isCaptcha($text)){
		$yandex->getFormData($text);
		$data = $yandex->getData();
	} else {
		echo "<h1>-NO CAPTCHA-</h1>";
		echo $text;
		exit;
	}
}
?>
<form action="" method="post">
	<img src="<?=$data['img']?>"><br/>
	<input name="captcha" type="text"><input type="submit" value="Go!">
	<input type="hidden" name="key" value="<?=$data['key']?>">
	<input type="hidden" name="form_action" value="<?=$data['form_action']?>">
	<input type="hidden" name="form_referer" value="<?=$gc->getReferer()?>">
	<input type="hidden" name="retpath" value="<?=$data['retpath']?>">
	<input type="hidden" name="load_captcha" value="1">
</form>