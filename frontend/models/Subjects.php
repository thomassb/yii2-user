<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Subjects".
 *
 * @property integer $ID
 * @property string $Subject
 *
 * @property SubjectAreas[] $subjectAreas
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Subject'], 'required'],
            [['Subject'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Subject' => 'Subject',
        ];
    }
//   public static function find()
//{
//    return parent::find()->where(['=', self::tableName().'.SchoolID', \Yii::$app->user->identity->SchoolID]);
//}
//public static function delete() {
//    return parent::delete()->where(['=', self::tableName().'.SchoolID', \Yii::$app->user->identity->SchoolID]);
//}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectAreas()
    {
        return $this->hasMany(SubjectAreas::className(), ['SubjectID' => 'ID']);
    }
      public static function SubjectList(){
     
        return Subjects::find()->all();
    }
}
