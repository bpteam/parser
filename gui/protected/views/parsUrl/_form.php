<?php
/* @var $this ParsUrlController */
/* @var $model ParsUrl */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pars-url-form',

	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны к заполнению.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_url_id'); ?>
		<?php echo $form->dropDownList($model,'type_url_id',Lookup::items('TypeUrl')); ?>
		<?php echo $form->error($model,'type_url_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'module_id'); ?>
		<?php echo $form->dropDownList($model,'module_id', Lookup::items('Module')); ?>
		<?php echo $form->error($model,'module_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'site_id'); ?>
		<?php echo $form->dropDownList($model,'site_id', Lookup::items('SiteList')); ?>
		<?php echo $form->error($model,'site_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state_id'); ?>
		<?php echo $form->dropDownList($model,'state_id', Lookup::items('State')); ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_run'); ?>
		<?php echo $form->textField($model,'last_run'); ?>
		<?php echo $form->error($model,'last_run'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->