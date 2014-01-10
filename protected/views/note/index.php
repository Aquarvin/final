<?php 
$this->Widget('zii.widgets.CListView', array(
  'dataProvider'=>$dataProvider,
  'itemView'=>'_listItem',
  'template' => '{items} {sorter}  {pager}  ',
  'pager' => array(
  	'header' =>'',
    'htmlOptions' => array(
      'class' => 'inverse')),
   'pagerCssClass' => 'pagination',
)); ?>