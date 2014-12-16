<?php
/* @var $this ParsUrlController */
/* @var $model ParsUrl */

$this->breadcrumbs=array(
	'Pars Urls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Управление ссылками', 'url'=>array('admin')),
);
?>

<h1>Create ParsUrl</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>