<?php

/**
 * This is the model class for table "pars_url".
 *
 * The followings are the available columns in table 'pars_url':
 * @property integer $id
 * @property string $url
 * @property integer $type_url_id
 * @property integer $module_id
 * @property integer $site_id
 * @property integer $state_id
 * @property integer $last_run
 *
 * The followings are the available model relations:
 * @property TypeUrl $typeUrl
 * @property Module $module
 * @property SiteList $siteList
 * @property State $state
 */
class ParsUrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pars_url';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url, type_url_id, module_id, site_id, state_id', 'required'),
			array('type_url_id, module_id, site_id, state_id, last_run', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, url, type_url_id, module_id, site_id, state_id, last_run', 'safe', 'on'=>'search'),
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
			'typeUrl' => array(self::BELONGS_TO, 'TypeUrl', 'type_url_id'),
			'module' => array(self::BELONGS_TO, 'Module', 'module_id'),
			'siteList' => array(self::BELONGS_TO, 'SiteList', 'site_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Ссылка',
			'type_url_id' => 'Тип ссылки',
			'module_id' => 'Модуль',
			'site_id' => 'Сайт',
			'state_id' => 'Статус',
			'last_run' => 'Последний запуск',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('type_url_id',$this->type_url_id);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('last_run',$this->last_run);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if(parent::beforeSave()){
			$this->last_run = 0;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ParsUrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
