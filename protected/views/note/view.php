    <dl class="dl-horizontal">
      <dt><?php echo Yii::t('main','Title');?></dt>
      <dd><?php echo $model->title?></dd>
      <dt><?php echo Yii::t('main','Text');?></dt>
      <dd><?php echo nl2br($model->note); ?></dd>
      <dt><?php echo Yii::t('main','Author');?></dt>
      <dd><?php echo $model->author->name?></dd>
    </dl>
  </fieldset>
<!-- кнопочки под заметкой -->
<div class="content">
      <?php 
      $params = array('model'=>$model);
      if (Yii::app()->user->checkAccess('delete_and_edit',$params)||Yii::app()->user->checkAccess('role_admin')): ?>
      
        <br>
        <?php  echo CHtml::link(Yii::t('main','Edit'),array('note/edit','id'=>$id,),
                                      array('class'=>'btn')); ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php  echo CHtml::link(Yii::t('main','Delete'),array('note/delete','id'=>$id,),
                                        array('class'=>'btn')); ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php  echo CHtml::link(Yii::t('main','Back'),array('note/index'),
                                        array('class'=>'btn')); ?>
      <?php endif ?>
        
</div>
<br>
<div class="comments">
      <!-- Список комментариев -->
      <?php  
      function ifButton($model)
      { 
           if ($model->author_id==Yii::app()->user->getID())
           {
              return TRUE;
            }
        return FALSE;
      }


      $delete = ifButton($model);
              // 'varyByExpression' => function() { return Yii::app()->user->checkAccess('author'); }, 
      // echo Yii::app()->user->name;
      if($this->beginCache($model->id,array(
              'duration'=>360,
              'dependency'=>array(
                'class'=>'CChainedCacheDependency',
                'dependencies'=>array(
                      array(
                        'class'=>'CExpressionDependency',
                        'expression' => 'Yii::app()->user->isGuest',
                      ),
                      array(
                        'class'=>'CDbCacheDependency',
                        'sql'=>'SELECT COUNT(id) FROM comments WHERE note_id='.$model->id,
                      ),
                )
              )
        )))
      { 
          $this->Widget('application.extensions.MyWidget.MyWidget',array(
                'comments'=>$model->comments,
                'delete'=>$delete,
                'note_id'=>$model->id,
                ));
           
        $this->endCache();  } ?>
      <!-- Создание нового комментария -->
      <?php $this->renderPartial('_commentForm', array('comment'=>$comment)); ?>

</div>
</body>
</html>