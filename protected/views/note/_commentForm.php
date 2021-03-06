<?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'comment-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'focus'=>array($comment,'comment'),
    )); ?>

<?php echo $form->errorSummary($comment); ?>
    
<div class="row">
    <?php echo $form->labelEx($comment,'comment',array('label'=>Yii::t('main', 'Comment'))); ?>
    <?php echo $form->textArea($comment,'comment',array('rows'=>5,'cols'=>100)); ?>
    <?php echo $form->error($comment,'comment'); ?>
</div>
<div class="row">
    <?php echo $form->labelEx($comment,'author'); ?>
    <?php echo $form->textField($comment,'author'); ?>
    <?php echo $form->error($comment,'author'); ?>
</div>

<?php if(CCaptcha::checkRequirements()):?>
    <?php echo CHtml::activeLabelEx($comment, 'verifyCode')?>
    <?php $this->widget('CCaptcha')?>
    <?php echo CHtml::activeTextField($comment, 'verifyCode')?>
<?php endif ?>

<div class="row submit">
    <?php echo CHtml::submitButton( Yii::t('main', 'Create'), array('class' => 'btn')); ?>
</div>

<?php $this->endWidget(); ?>

