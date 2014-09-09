<?php
/* @var $this ParsUrlController */
/* @var $model ParsUrl */

$this->breadcrumbs=array(
	'Pars Urls'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Добавить ссылку', 'url'=>array('create')),
);
?>

<h1>Управление ссылками для парсинга</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pars-url-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name' => 'url',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->url), $data->url)'
		),
		array(
			'name' => 'type_url_id',
			'value' => 'Lookup::item("TypeUrl", $data->type_url_id)',
			'filter' => Lookup::items("TypeUrl"),
		),
		array(
			'name' => 'module_id',
			'value' => 'Lookup::item("Module", $data->module_id)',
			'filter' => Lookup::items("Module"),
		),
		array(
			'name' => 'site_id',
			'value' => 'Lookup::item("SiteList", $data->site_id)',
			'filter' => Lookup::items("SiteList"),
		),
		array(
			'name' => 'state_id',
			'value' => 'Lookup::item("State", $data->state_id)',
			'filter' => Lookup::items("State"),
		),
		array(
			'name' => 'last_run',
			'type' => 'raw',
			'value' => 'date("h:i d-m-Y",$data->last_run)',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
