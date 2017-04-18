<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "PupilStartingLevel".
 *
 * @property integer $ID
 * @property integer $PupilID
 * @property integer $StrandID
 * @property integer $StartingLevel
 * @property string $LevelDate
 * @property Strands $strand
 * @property Pupils $pupil
 */
class PupilStartingLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PupilStartingLevel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PupilID', 'StrandID'], 'required'],
            [['PupilID', 'StrandID', 'StartingLevel'], 'integer'],
            ['LevelDate','safe'],
            [['StrandID'], 'exist', 'skipOnError' => true, 'targetClass' => Strands::className(), 'targetAttribute' => ['StrandID' => 'ID']],
            [['PupilID'], 'exist', 'skipOnError' => true, 'targetClass' => Pupils::className(), 'targetAttribute' => ['PupilID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PupilID' => 'Pupil ID',
            'StrandID' => 'Strand ID',
            'StartingLevel' => 'Starting Level',
        ];
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
    public function getPupil()
    {
        return $this->hasOne(Pupils::className(), ['ID' => 'PupilID']);
    }
       /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Levels::className(), ['ID' => 'StartingLevel']);
    }
}
