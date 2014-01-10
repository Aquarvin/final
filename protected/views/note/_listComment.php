

<div class="comment">

	<div class="author">
		<b><font color="green"><?php echo $comment->author; ?></font></b>:
		<font color="#a8a8a8"><?php echo $comment->date; ?></font>
	</div>
	<p><?php echo nl2br(CHtml::encode($comment->comment)); ?></p>

</div><!-- comment -->
<hr>