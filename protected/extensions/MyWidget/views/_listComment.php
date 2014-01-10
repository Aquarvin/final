<div class="comment">
	<div class="row-fluid">
 		<div class="span9">
			<b><font color="green"><?php echo $comment->author; ?></font></b>:
			<font color="#a8a8a8"><?php echo $comment->date; ?></font>
		</div>
    	<!-- <div class="row-fluid"> -->
 			<div class="span10">
				<p class="text-left"><?php echo nl2br(CHtml::encode($comment->comment)); ?></p>
			</div>
		
    	<!-- </div> -->
    		<?php if ($delete): ?>
 			<div class="span12">
				<?php echo CHtml::link(Yii::t('main','Delete'),array('comment/delete','id'=>$comment->id,'note_id'=>$note_id),
                                        	array('class'=>'btn pull-right')); ?>
			</div>
			<?php endif ?>
    </div>
</div>
<hr>
