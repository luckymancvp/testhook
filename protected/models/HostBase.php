<?php

/**
 * This is the DAO model class for table "host".
 *
 * The followings are the available columns in table 'host':
 * @property integer $id
 * @property string $hostname
 * @property string $username
 * @property string $port
 * @property string $key
 * @property string $create_date
 * @property string $update_date
 *
 * The followings are the available model relations:
 * @property Repository[] $repositories
 */
abstract class HostBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Host the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'host';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hostname, key, create_date, update_date', 'required'),
			array('hostname, username, port, key', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hostname, username, port, key, create_date, update_date', 'safe', 'on'=>'search'),
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
			'repositories' => array(self::HAS_MANY, 'Repository', 'host_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hostname' => 'Hostname',
			'username' => 'Username',
			'port' => 'Port',
			'key' => 'Key',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('hostname',$this->hostname,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('port',$this->port,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}