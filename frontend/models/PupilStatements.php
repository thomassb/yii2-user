<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "PupilStatements".
 *
 * @property integer $ID
 * @property integer $PupilID
 * @property integer $StatementID
 * @property string $PartiallyDate
 * @property string $AchievedDate
 * @property string $ConsolidatedDate
 *
 * @property Statements $statement
 * @property Pupils $pupil
 */
class PupilStatements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PupilStatements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PupilID', 'StatementID'], 'required'],
            [['PupilID', 'StatementID'], 'integer'],
            [['PartiallyDate', 'AchievedDate', 'ConsolidatedDate'], 'safe'],
            [['StatementID'], 'exist', 'skipOnError' => true, 'targetClass' => Statements::className(), 'targetAttribute' => ['StatementID' => 'ID']],
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
            'StatementID' => 'Statement ID',
            'PartiallyDate' => 'Partially Date',
            'AchievedDate' => 'Achieved Date',
            'ConsolidatedDate' => 'Consolidated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatement()
    {
        return $this->hasOne(Statements::className(), ['ID' => 'StatementID']);
    }
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupil()
    {
        return $this->hasOne(Pupils::className(), ['ID' => 'PupilID']);
    }
    public function beforeValidate() {
        //format dates
        if($this->PartiallyDate!=''){
            $this->PartiallyDate = \Yii::$app->formatter->asDatetime($this->PartiallyDate, "php:Y-m-d");
        }
        if($this->AchievedDate!=''){
            $this->AchievedDate = \Yii::$app->formatter->asDatetime($this->AchievedDate, "php:Y-m-d");
        }
        if($this->ConsolidatedDate!=''){
            $this->ConsolidatedDate = \Yii::$app->formatter->asDatetime($this->ConsolidatedDate, "php:Y-m-d");
        }
        return parent::beforeValidate();
    }
}
