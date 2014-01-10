<div class="row-fluid">
	<div class="span3">
		<?php echo CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->id)); ?>
	</div>
	<div class="span3">
		<?php echo $data['note']?>
	</div>
	<div class="span3 text-right">
		<?php echo CHtml::link(CHtml::encode($data->author->name),array('author','author_id'=>$data->author_id)); ?>
	</div>
	<div class="span3">
		<?php echo date('Y-m-d G:H:i',strtotime($data['date']));?>
	</div>
</div>	