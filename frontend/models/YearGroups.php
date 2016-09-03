<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "YearGroups".
 *
 * @property integer $ID
 * @property string $YearGroup
 * @property integer $DaysOld
 *
 * @property KeyStageYearGroups $keyStageYearGroups
 */
class YearGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'YearGroups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['YearGroup'], 'required'],
            [['DaysOld'], 'integer'],
            [['YearGroup'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'YearGroup' => 'Year Group',
            'DaysOld' => 'Days Old',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeyStageYearGroups()
    {
        return $this->hasOne(KeyStageYearGroups::className(), ['YearGroupID' => 'ID']);
    }
}
