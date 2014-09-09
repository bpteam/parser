<?php
/* @var $this ModuleController */
/* @var $model Module */

$this->breadcrumbs=array(
	'Modules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление модулями', 'url'=>array('admin')),
);
?>

<h1>Добавление модуля</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>