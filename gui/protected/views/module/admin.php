<?php
/* @var $this ModuleController */
/* @var $model Module */

$this->breadcrumbs=array(
	'Modules'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Добавить модуль', 'url'=>array('create')),
);
?>

<h1>Управление модулями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'module-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'class_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
