<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "KeyStageYearGroups".
 *
 * @property integer $KeystageID
 * @property integer $YearGroupID
 *
 * @property YearGroups $yearGroup
 * @property Keystages $keystage
 */
class KeyStageYearGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'KeyStageYearGroups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KeystageID', 'YearGroupID'], 'required'],
            [['KeystageID', 'YearGroupID'], 'integer'],
            [['YearGroupID'], 'exist', 'skipOnError' => true, 'targetClass' => YearGroups::className(), 'targetAttribute' => ['YearGroupID' => 'ID']],
            [['KeystageID'], 'exist', 'skipOnError' => true, 'targetClass' => Keystages::className(), 'targetAttribute' => ['KeystageID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KeystageID' => 'Keystage ID',
            'YearGroupID' => 'Year Group ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYearGroup()
    {
        return $this->hasOne(YearGroups::className(), ['ID' => 'YearGroupID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeystage()
    {
        return $this->hasOne(Keystages::className(), ['ID' => 'KeystageID']);
    }
}
