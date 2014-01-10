
<div class="row-fluid">
 	<div class="span3">
 		<? echo CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->id)); ?>
    </div>
 	<div class="span3">
    	<?=$data['note']?>
    </div>
 	<div class="span3 text-right">
	    <? 

	    	// var_dump($data->author);
	    echo CHtml::link(CHtml::encode($data->author->name),array('author','author_id'=>$data->author_id)); ?>
    </div>
 	<div class="span3">
	    <? echo date('Y-m-d G:H:i',strtotime($data['date']));?>
    </div>
</div>	