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
class Classes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Classes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ClassName'], 'required'],
            [['ClassName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ClassName' => 'Class Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupils()
    {
        return $this->hasMany(Pupils::className(), ['ClassID' => 'ID']);
    }
    public static function ClassList(){
        //TODO:: Add school variable 
        return Classes::findAll(['SchoolID'=>2,'active'=>1]);
    }
}
