<?php
/* @var $this SiteListController */
/* @var $model SiteList */

$this->breadcrumbs=array(
	'Site Lists'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Добавить сайт', 'url'=>array('create')),
	array('label'=>'Управление сайтами', 'url'=>array('admin')),
);
?>

<h1>Редактирование сайта <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>