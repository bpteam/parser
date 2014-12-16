<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 07.09.14
 * Time: 14:22
 * Project: parser
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

abstract class Lookup extends CActiveRecord {

	protected static $_items=array();

	public static function item($type, $id)
	{
		if(!isset(self::$_items[$type][$id])){
			self::loadItems($type);
		}
		return self::$_items[$type][$id];
	}

	public static function items($type)
	{
		if(!isset(self::$_items[$type])){
			self::loadItems($type);
		}
		return self::$_items[$type];
	}

	static function loadItems($type){
		self::$_items[$type]=array();
		$models=$type::model()->findAll(array(
			'order'=>'id',
		));
		foreach($models as $model)
			self::$_items[$type][$model->id]=$model->title;
	}
}