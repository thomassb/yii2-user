<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Strands".
 *
 * @property integer $ID
 * @property string $StrandText
 *
 * @property PupilStartingLevel[] $pupilStartingLevels
 * @property Statements[] $statements
 * @property SubjectAreas[] $subjectAreas
 */
class Strands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Strands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StrandText'], 'required'],
            [['StrandText'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'StrandText' => 'Strand Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupilStartingLevels()
    {
        return $this->hasMany(PupilStartingLevel::className(), ['StrandID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatements()
    {
        return $this->hasMany(Statements::className(), ['StrandID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectAreas()
    {
        return $this->hasMany(SubjectAreas::className(), ['AreaID' => 'ID']);
    }
}
