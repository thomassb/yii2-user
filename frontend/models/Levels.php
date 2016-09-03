<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Levels".
 *
 * @property integer $ID
 * @property string $LevelText
 *
 * @property Statements[] $statements
 */
class Levels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Levels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LevelText'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'LevelText' => 'Level Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatements()
    {
        return $this->hasMany(Statements::className(), ['LevelID' => 'ID']);
    }
}
