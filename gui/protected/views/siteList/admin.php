<?php
/* @var $this SiteListController */
/* @var $model SiteList */

$this->breadcrumbs=array(
	'Site Lists'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SiteList', 'url'=>array('index')),
	array('label'=>'Create SiteList', 'url'=>array('create')),
);
?>

<h1>Управление сайтами</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-list-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'description',
		array(
			'name' => 'module_id',
			'value' => 'Lookup::item("Module", $data->module_id)',
			'filter' => Lookup::items("Module"),
		),
		array(
			'name' => 'state_id',
			'value' => 'Lookup::item("State", $data->state_id)',
			'filter' => Lookup::items("State"),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
