<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "LevelsText".
 *
 * @property integer $ID
 * @property integer $LevelID
 * @property integer $LevelPercentage
 * @property integer $LevelValue
 * @property string $LevelText
 */
class LevelsText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'LevelsText';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LevelID', 'LevelPercentage', 'LevelValue'], 'integer'],
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
            'LevelID' => 'Level ID',
            'LevelPercentage' => 'Level Percentage',
            'LevelValue' => 'Level Value',
            'LevelText' => 'Level Text',
        ];
    }
}
