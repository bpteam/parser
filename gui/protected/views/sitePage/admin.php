<?php
/* @var $this SitePageController */
/* @var $model SitePage */

$this->breadcrumbs=array(
	'Site Pages'=>array('index'),
	'Manage',
);
?>
<h1>Управление страницами</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'hash',
		'url',
		'html',
		'time',
		array(
			'name' => 'site_id',
			'value' => 'Lookup::item("SiteList", $data->site_id)',
			'filter' => Lookup::items("SiteList"),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
