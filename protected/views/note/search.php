
<fieldset class="content">
    <legend style="text-align: left;"><?echo Yii::t('main','Search results');?></legend>

<?php $this->Widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_listItem',
  'template' => '{items} {sorter}  {pager}  ',
  'pager' => array(
  	'header' =>'',
    'htmlOptions' => array(
      'class' => '')),
   'pagerCssClass' => 'pagination',
)); ?>

</fieldset>
</body>
</html>