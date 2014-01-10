<?php
	include ('models/Comment.php');
	class RemovespamCommand extends  CConsoleCommand
	{
		public $spamFrases = array  (
			'100% satisfied','Buy direct','Click to remove', 'Dear friend', 'Free mambership');
		public function Run()
		{
			$criteria = new CDbCriteria;
			foreach ($this->spamFrases as $spam) 
			{
				$criteria->select = 'ID';
				$criteria->condition = 'COMMENT LIKE :spam';
				$criteria->params = array(':spam'=>"%$spam%");
				if (Comment::model()->deleteAll($criteria))
					$logIt = TRUE;
			}

			if(isset($logIt))
			{
				$message='Spam-comments were removed';
    			$level='info';
    			$category='REMOVED.SPAM';
    			Yii::log($message, $level, $category);
    		}
		}
	}
?>