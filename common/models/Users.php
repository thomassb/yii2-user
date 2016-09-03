<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $isadmin
 * @property integer $SchoolID
 * @property boolean $Active
 * @property integer $Role
 * @property string $Created
 *
 * @property Schools $school
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SchoolID', 'Role'], 'required'],
            [['SchoolID', 'Role'], 'integer'],
            [['Active'], 'boolean'],
            [['Created'], 'safe'],
            [['username', 'password', 'salt'], 'string', 'max' => 250],
            [['isadmin'], 'string', 'max' => 1],
            [['SchoolID'], 'exist', 'skipOnError' => true, 'targetClass' => Schools::className(), 'targetAttribute' => ['SchoolID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'isadmin' => 'Isadmin',
            'SchoolID' => 'School ID',
            'Active' => 'Active',
            'Role' => 'Role',
            'Created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(Schools::className(), ['ID' => 'SchoolID']);
    }
}
