<?php

/**
 * This is the DAO model class for table "repository".
 *
 * The followings are the available columns in table 'repository':
 * @property integer $id
 * @property string $repo
 * @property integer $host_id
 * @property string $path
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Host $host
 */
abstract class RepositoryBase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Repository the static model class
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
		return 'repository';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('repo, host_id, path, create_time, update_time', 'required'),
			array('host_id', 'numerical', 'integerOnly'=>true),
			array('repo, path', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, repo, host_id, path, create_time, update_time', 'safe', 'on'=>'search'),
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
			'host' => array(self::BELONGS_TO, 'Host', 'host_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'repo' => 'Repo',
			'host_id' => 'Host',
			'path' => 'Path',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('repo',$this->repo,true);
		$criteria->compare('host_id',$this->host_id);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}