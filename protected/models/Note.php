<?php

/**
 * This is the model class for table "Notes".
 *
 * @property integer $ID
 * @property string $author_ID
 * @property string $TITLE
 * @property string $NOTE
 * @property string $DATE
 */
class Note extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('author_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>30),
			array('note, date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, author_id, title, note, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		  return array(
        	'comments' => array(self::HAS_MANY, 'comment', 'note_id',
            	// 'condition'=>'comments.status='.Comment::STATUS_APPROVED,
            	'order'=>'comments.date DESC'),
        	'commentCount' => array(self::STAT, 'comment', 'note_id'),
        	'author'=>array(self::BELONGS_TO, 'User', 'author_id')
    	);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		// echo  $this->getLocale(); die;
		return array(
			'id' => 'ID',
			'title' => Yii::t('main', 'Title'),
			'note' => Yii::t('main','Note'),
			'author_id' => Yii::t('main','Author'),
			'date' => Yii::t('main','Date'),
		);
	}

	public function addComment($comment)
	{
    	$comment->note_id = $this->id;
    	return $comment->save();
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Note the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
