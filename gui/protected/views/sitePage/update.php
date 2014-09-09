<?php
/* @var $this SitePageController */
/* @var $model SitePage */

$this->breadcrumbs=array(
	'Site Pages'=>array('index'),
	$model->hash=>array('view','id'=>$model->hash),
	'Update',
);

$this->menu=array(
	array('label'=>'Управление страницами', 'url'=>array('admin')),
);
?>

<h1>Редактирование страницы <?php echo $model->hash; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>