<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "KeyStageYearGroups".
 *
 * @property integer $KeystageID
 * @property integer $YearGroupID
 *
 * @property Keystages $keystage
 * @property YearGroups $yearGroup
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
            [['KeystageID'], 'exist', 'skipOnError' => true, 'targetClass' => Keystages::className(), 'targetAttribute' => ['KeystageID' => 'ID']],
            [['YearGroupID'], 'exist', 'skipOnError' => true, 'targetClass' => YearGroups::className(), 'targetAttribute' => ['YearGroupID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KeystageID' => Yii::t('app', 'Keystage ID'),
            'YearGroupID' => Yii::t('app', 'Year Group ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeystage()
    {
        return $this->hasOne(Keystages::className(), ['ID' => 'KeystageID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYearGroup()
    {
        return $this->hasOne(YearGroups::className(), ['ID' => 'YearGroupID']);
    }
}
