<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Statements".
 *
 * @property integer $ID
 * @property string $StatementText
 * @property integer $StrandID
 * @property integer $LevelID
 *
 * @property PupilStatements[] $pupilStatements
 * @property Strands $strand
 * @property Levels $level
 */
class Statements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Statements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StatementText', 'StrandID', 'LevelID'], 'required'],
            [['StatementText'], 'string'],
            [['StrandID', 'LevelID'], 'integer'],
            [['StrandID'], 'exist', 'skipOnError' => true, 'targetClass' => Strands::className(), 'targetAttribute' => ['StrandID' => 'ID']],
            [['LevelID'], 'exist', 'skipOnError' => true, 'targetClass' => Levels::className(), 'targetAttribute' => ['LevelID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'StatementText' => 'Statement Text',
            'StrandID' => 'Strand ID',
            'LevelID' => 'Level ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupilStatements()
    {
        return $this->hasMany(PupilStatements::className(), ['StatementID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStrand()
    {
        return $this->hasOne(Strands::className(), ['ID' => 'StrandID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Levels::className(), ['ID' => 'LevelID']);
    }
}
