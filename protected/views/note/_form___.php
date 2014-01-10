<?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'enableClientValidation'=>true,
        'focus'=>array($model,'title'),
    )); ?>

<?php echo $form->errorSummary($model); ?>
    
<div class="row">
    <?php echo $form->labelEx($model,'title'); ?>
    <?php echo $form->textField($model,'title'); ?> 
    <?php echo $form->error($model,'title'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($model,'note',array('label'=>Yii::t('main', 'Text'))); ?>
    <?php echo $form->textArea($model,'note',array('rows'=>'5')); ?>
    <?php echo $form->error($model,'note'); ?>
</div>
<div class="row">
    <div class="span0"><? echo Yii::t('main','Author').":";?> </div>
    <div class="span2"><?php echo Yii::app()->user->name; ?></div>
    <?php echo $form->hiddenField($model,'author_id',array('value'=>Yii::app()->user->getID())); ?>
</div>
<br>
<div class="row submit">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('main', 'Create') : Yii::t('main', 'Save'), array('class' => 'btn')); ?>
</div>

<?php $this->endWidget(); ?>