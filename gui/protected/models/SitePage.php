<?php

/**
 * This is the model class for table "site_page".
 *
 * The followings are the available columns in table 'site_page':
 * @property string $hash
 * @property string $url
 * @property string $html
 * @property integer $time
 * @property integer $site_id
 *
 * The followings are the available model relations:
 * @property Site $site
 */
class SitePage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hash, site_id', 'required'),
			array('time, site_id', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			array('url, html', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hash, url, time, site_id', 'safe', 'on'=>'search'),
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
			'siteList' => array(self::BELONGS_TO, 'SiteList', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hash' => 'Хэш',
			'url' => 'Ссылка',
			'html' => 'Данные',
			'time' => 'Дата',
			'site_id' => 'Сайт',
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

		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('html',$this->html,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('site_id',$this->site_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitePage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
