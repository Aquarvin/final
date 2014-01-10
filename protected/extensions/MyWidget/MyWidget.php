<?php
class MyWidget extends CWidget
{
	public $comments;
    public $delete=FALSE;
    public $note_id;
	
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
    public function run()
    {
    	
    	$this->render('main',array(
            'comments' => $this->comments,
            'delete'=>$this->delete,
            'note_id'=>$this->note_id));
    }
}
?>