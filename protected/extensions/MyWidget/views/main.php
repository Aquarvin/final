<?php
	if (!empty($comments))
 		echo "<p>".Yii::t('main','Comments').":</p>";

	foreach ($comments as $comment)
	{
		$this->render('_listComment', array('comment'=>$comment,
																				'delete'=>$delete,
																				'note_id'=>$note_id));
	}
?> 