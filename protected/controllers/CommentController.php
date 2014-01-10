<?php

class CommentController extends Controller
{

	// public $layout='//layouts/mainlist';

	public function actionIndex()

	{
		$dataProvider = new CActiveDataProvider('Comment', array(
    			'criteria'=>array(
    				'with'=>'Note',
    			),
			));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			));
	}
	public function filters() {
        return array(
            'accessControl',
        );
    }
  
    public function accessRules() {
        return array(
            // если используется проверка прав, не забывайте разрешить доступ к
            // действию, отвечающему за генерацию изображения
            // array('allow',
            //     // 'actions'=>array('captcha'),
            //     'actions'=>array('delete'),
            //     'users'=>array('*'),
            // ),
            array('allow',
                // 'actions'=>array('captcha'),
                'actions'=>array('create','edit','delete','logout','view','deletecomment'),
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
	public function actionDelete($id,$note_id)
	{
		$model = Comment::model()->findByPk($id);
        $message=Yii::t('main','Comment')./*" '".$model->attributes['COMMENT'].*/" ".Yii::t('main','was deleted');
        $level='info';
        $category='DELETED.COMMENT';
        Yii::log($message, $level, $category);
		Yii::app()->user->setFlash('error', $message);
		Comment::model()->deleteByPk($id);
		# ниже приведенный пример не работает. странно
		// $model->delete(); // удаляем строку из таблицы
		$this->redirect(array('note/view','id'=>$note_id));
	}
}

?>