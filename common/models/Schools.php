<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Schools".
 *
 * @property integer $ID
 * @property string $Name
 *
 * @property Users[] $users
 */
class Schools extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Schools';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['SchoolID' => 'ID']);
    }
      public static function SchoolList() {
        //TODO:: Add school variable 
        return Schools::find()->all();
    }
}
