<?php
/* @var $this ParsUrlController */
/* @var $model ParsUrl */

$this->breadcrumbs=array(
	'Pars Urls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Добавить ссылку', 'url'=>array('create')),
	array('label'=>'Управление ссылками', 'url'=>array('admin')),
);
?>

<h1>Update ParsUrl <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>