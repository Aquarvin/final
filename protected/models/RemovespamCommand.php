<?php
	/**
	* 
	*/
	class RemovespamCommand extends  CConsoleCommand
	{
		public $spamPhrases as array  (
			'100% satisfied','Buy direct','Click to remove', 'Dear friend', 'Free mambership');
		public function run()
		{
			$db=Yii::app()->db;
			
			$criteria = new CDbCriteria;
			foreach ($spamPhrases as $spam) 
			{
				$criteria->select = 'id';
				$criteria->condition = 'COMMENT LIKE :spam';
				$criteria->params = array(':spam'=>"%$spam%");
				Comment::model()->deleteAll($criteria);

			}

		}
	}
?>