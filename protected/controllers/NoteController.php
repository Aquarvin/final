<?php

class NoteController extends Controller
{

	public $layout='//layouts/mainlist';

	public function filters() {
		return array(
			'accessControl',
		   
		);
	}

	public function accessRules() {
		return array(
			// если используется проверка прав, не забывайте разрешить доступ к
			// действию, отвечающему за генерацию изображения
			array('allow',
				'actions'=>array('view','index','logout','login','search','author','captcha','error','theme'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','edit','delete','logout','login',),
				'roles'=>array('role_author'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	public function actionLogin()
	{
		$serviceName = Yii::app()->request->getQuery('service');
        if (isset($serviceName)) {
            /** @var $eauth EAuthServiceBase */
            $eauth = Yii::app()->eauth->getIdentity($serviceName);
            $eauth->redirectUrl = Yii::app()->user->returnUrl;
            $eauth->cancelUrl = $this->createAbsoluteUrl('site/login');
            try {
            		//echo "sdfsdf"; die;
                if ($eauth->authenticate()) {
                    //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
                    $identity = new EAuthUserIdentity($eauth);

                    // successful authentication
                    if ($identity->authenticate()) {
                        Yii::app()->user->login($identity);
                        //var_dump($identity->id, $identity->name, Yii::app()->user->id);exit;

                        // special redirect with closing popup window
                        $eauth->redirect();
                    }
                    else {
                        // close popup window and redirect to cancelUrl
                        $eauth->cancel();
                    }
                }

                // Something went wrong, redirect to login page
                $this->redirect(array('site/login'));
            }
            catch (EAuthException $e) {
                // save authentication error to session
                Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
		$model = new LoginForm;

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$message='User '.Yii::app()->user->name.' has logged in';
				$level='info';
				$category='LOGIN';
				Yii::log($message, $level, $category);
				Yii::app()->request->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		$message='User '.Yii::app()->user->name.' has logged out';
		$level='info';
		$category='LOGOUT';
		Yii::log($message, $level, $category);
		Yii::app()->user->logout();
		Yii::app()->request->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
			),
		);
	}

	public function actionIndex()

	{
		$dataProvider = new CActiveDataProvider('Note', array(
				'criteria'=>array(
					'order'=>'id ASC',
				),
				'pagination'=>array(
					'pageSize'=>10,
				),
			));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionAuthor($author_id)

	{
		$dataProvider = new CActiveDataProvider('Note', array(
				'criteria'=> array(
					'condition'=>'author_id=:author_id',
					'params' => array(':author_id'=>$author_id)),
				'pagination'=>array(
					'pageSize'=>10,
				),
			));
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
				));
	}

	public function actionView($id)
	{
		// $model = new Note;
		$model = Note::model()->findByPk($id);
		$comment = $this->newComment($model);
		$this->render('view',array(
			'id'=>$id,
			'model'=>$model,
			'comment'=>$comment,
		));
	}


	protected function newComment($model)
	{
		$comment = new Comment;
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($model->addComment($comment))
			{
				$message='Comment has been added';
				$level='info';
				$category='Create.Comment';
				Yii::log($message, $level, $category);
				Yii::app()->user->setFlash('succses','Thank you for your comment. Your comment has been added');
				$this->refresh();
			}
		}
		return $comment;
	}

	public function actionCreate()
	{
		$model = new Note;
		if(isset($_POST['Note'])) 
		{
			// 	$_POST['Note']['author_ID']=(int)$_POST['Note']['author_ID'];
			$model->attributes=$_POST['Note'];

			if($model->save())
			{
				$message=Yii::t('main','Note')." '".$model->attributes['title']."' ".Yii::t('main','was created');
				// $message=var_export($_POST['Note'],true);
				$level='info';
				$category='Create.Note';
				Yii::log($message, $level, $category);
				Yii::app()->user->setFlash('success', $message);
				$this->redirect(Yii::app()->createUrl('note/index'));

			}
		}
		$this->render('create',array('model'=>$model));
	}

	public function actionEdit($id)
	{
		$model = Note::model()->findByPk($id);
		if (isset($_POST['Note']))
		{
			$attributesBefor = $model->attributes; 
			$model->attributes=$_POST['Note'];

			if ($attributesBefor==$model->attributes)
			{
				Yii::app()->user->setFlash('info', Yii::t('main','Note')." '".$model->attributes['title']."' ".Yii::t('main','was not edited'));
				//$this->render('index');
				$this->redirect(Yii::app()->createUrl('note/index'));
			}
			if($model->save())
			{
				$message=Yii::t('main','Note')." '".$model->attributes['title']."' ".Yii::t('main','was edited');
				$level='info';
				$category='EDITED';
				Yii::log($message, $level, $category);
				Yii::app()->user->setFlash('success', $message);
				// Note::model()->updateByPk($id,$model->attributes);
				$this->redirect(Yii::app()->createUrl('note/index'));
			}
		}
		$this->render('edit',array(
			'id'=>$id,
			'model'=>$model,
		));
	}
	public function actionDelete($id)
	{	
		$model = Note::model()->findByPk($id);
		$comments=$model->comments;
		$message=Yii::t('main','Note')." '".$model->attributes['title']."' ".Yii::t('main','was deleted');
		$level='info';
		$category='DELETED.NOTE';
		Yii::log($message, $level, $category);
		Yii::app()->user->setFlash('error', $message);
		Note::model()->deleteByPk($id);
		# ниже приведенный пример не работает. странно
		// $model->delete(); // удаляем строку из таблицы
		$this->redirect('index');
		
	}

	public function actionSearch($search)
	{			
		if(empty($search))
		{
			$this->redirect('index');
		}
		// $search = addcslashes($search, '%_');
		$criteria = new CDbCriteria;
		$criteria->alias='notes';
		$criteria->join = 'LEFT JOIN users ON users.id=notes.author_id';
		$criteria->select = 'notes.id, title, note, author_id';
		$criteria->condition = 'CONCAT( title, note, users.name) LIKE :search';
		$criteria->params = array(':search'=>"%$search%");
		// var_dump($criteria);die;
		#   вместо тех строк можно одну такую :
		#  $criteria->addSearchCondition('CONCAT( title, NOTE, AUTHOR)', $search);   
		$dataProvider = new CActiveDataProvider('Note', array(
				'criteria'=> $criteria,
				'pagination'=>array(
					'pageSize'=>10,),
			));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'search'=>$search,
		));
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	public function actionTheme($theme)
	{
		// echo $theme; die;
		//Yii::app()->theme->name=$theme;
		// var_dump(Yii::app()->theme); die;
		$this->redirect(Yii::app()->createUrl('note/index'));
	}
	public function log()
	{


	}
}

?>