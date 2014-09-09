<?php

/**
 * This is the model class for table "site_list".
 *
 * The followings are the available columns in table 'site_list':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $module_id
 * @property integer $state_id
 *
 * The followings are the available model relations:
 * @property ParsUrl[] $parsUrls
 * @property Module $module
 * @property State $state
 * @property SitePage[] $sitePages
 */
class SiteList extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, title, module_id, state_id', 'required'),
			array('id, module_id, state_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>250),
			array('description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, module_id, state_id', 'safe', 'on'=>'search'),
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
			'parsUrls' => array(self::HAS_MANY, 'ParsUrl', 'site_id'),
			'module' => array(self::BELONGS_TO, 'Module', 'module_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
			'sitePages' => array(self::HAS_MANY, 'SitePage', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Имя',
			'description' => 'Описание',
			'module_id' => 'Модуль',
			'state_id' => 'Статус',
		);
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('state_id',$this->state_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterDelete(){
		parent::afterDelete();
		ParsUrl::model()->deleteAll('site_id=' . $this->id);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SiteList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
