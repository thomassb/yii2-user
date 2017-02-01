<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "Classes".
 *
 * @property integer $ID
 * @property string $ClassName
 *
 * @property Pupils[] $pupils
 */
class Classes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Classes';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ClassName'], 'required'],
            [['ClassName'], 'string', 'max' => 250],
            [['active', 'SchoolID', 'UserID', 'Created'], 'safe'] // not correct
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'ClassName' => 'Class Name',
        ];
    }
    public static function find()
{
    return parent::find()->where(['=', self::tableName().'.SchoolID', \Yii::$app->user->identity->SchoolID]);
}
//    public function beforeValidate() {
//          $this->SchoolID = \Yii::$app->user->identity->SchoolID;
//        return parent::beforeValidate();
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupils() {
        return $this->hasMany(Pupils::className(), ['ClassID' => 'ID']);
    }

    public static function ClassList() {
        //TODO:: Add school variable 
        return Classes::findAll(['SchoolID' => \Yii::$app->user->identity->SchoolID, 'active' => 1]);
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->UserID = \Yii::$app->user->identity->id;
            $this->Created = time();
        }
        return parent::beforeSave($insert);
    }

}
