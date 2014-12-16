<?php
/* @var $this SiteListController */
/* @var $model SiteList */

$this->breadcrumbs=array(
	'Site Lists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление сайтами', 'url'=>array('admin')),
);
?>

<h1>Создание сайта</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>