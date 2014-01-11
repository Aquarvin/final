<?php 
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id' => 'edit-form',
            'type'=>'horizontal',
            'htmlOptions' => array('class' => 'well'),
        )
    );?>
<fieldset>
    <legend><?=Yii::t('main','New Note')?></legend>
        <?
        echo $form->errorSummary($model);
        echo $form->textFieldRow($model, 'title', array('class' => 'span3'));   
        echo $form->html5EditorRow($model,'note', array());
        /*echo $form->textAreaRow(
                    $model,
                    'note',
                    array('class' => 'span4', 'rows' => 5)
                ); */
        // echo "view"; die; 
        echo $form->hiddenField($model,'author_id',array('value'=>Yii::app()->user->id));
        ?>
</fieldset>
<div class="form-actions">
    <?
    $this->widget(
        'bootstrap.widgets.TbButton',
        array('buttonType' => 'submit', 'label' => $model->isNewRecord ? Yii::t('main', 'Create') : Yii::t('main', 'Save'))
    );
    ?>
</div>
<?
    $this->endWidget();
    unset($form); 
?>