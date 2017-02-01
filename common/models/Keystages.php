<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Keystages".
 *
 * @property integer $ID
 * @property string $KeyStage
 *
 * @property KeyStageYearGroups[] $keyStageYearGroups
 */
class Keystages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Keystages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KeyStage'], 'required'],
            [['KeyStage'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'KeyStage' => Yii::t('app', 'Key Stage'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKeyStageYearGroups()
    {
        return $this->hasMany(KeyStageYearGroups::className(), ['KeystageID' => 'ID']);
    }
}
