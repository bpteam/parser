<?php
/* @var $this ModuleController */
/* @var $model Module */

$this->breadcrumbs=array(
	'Modules'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Добавить модуль', 'url'=>array('create')),
	array('label'=>'Управление модулями', 'url'=>array('admin')),
);
?>

<h1>Редактирование модуля <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>