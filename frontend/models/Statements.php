<?php

namespace frontend\models;

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
class Statements extends \yii\db\ActiveRecord {

    public $PupilID;
    public $PartiallyDate;
    public $AchievedDate;
    public $ConsolidatedDate;
    public $SubjectID;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Statements';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['StatementText', 'StrandID', 'LevelID'], 'required'],
            [['StatementText'], 'string'],
            [['StrandID', 'LevelID', 'PupilID', 'SubjectID'], 'integer'],
            [['StrandID'], 'exist', 'skipOnError' => true, 'targetClass' => Strands::className(), 'targetAttribute' => ['StrandID' => 'ID']],
            [['LevelID'], 'exist', 'skipOnError' => true, 'targetClass' => Levels::className(), 'targetAttribute' => ['LevelID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
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
    public function getPupilStatements() {
        return $this->hasMany(PupilStatements::className(), ['StatementID' => 'ID']);
    }

    public function getPupilStatement() {

        // $this->PupilID = 1;
        if ($this->PupilID != null) {
            $r = $this->hasOne(PupilStatements::className(), ['StatementID' => 'ID'])->andOnCondition('PupilID= :pid', [':pid' => $this->PupilID])
            ;
        } else {
            return new PupilStatements;
        }
        return (count($r) == 0 ? [new PupilStatements] : $r);
        if ($r) {
            if (isset($r->PartiallyDate)) {
                $this->PartiallyDate = $r->PartiallyDate;
            }
            return $r;
        } else {
            return new PupilStatements;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStrand() {
        if (!$this->StrandID) {
            return new Strands();
        }
        return $this->hasOne(Strands::className(), ['ID' => 'StrandID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel() {
          if (!$this->LevelID) {
            return new Levels();
      }
        return $this->hasOne(Levels::className(), ['ID' => 'LevelID']);
    }
        public function getLevels() {

        return $this->hasOne(Levels::className(), ['ID' => 'LevelID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject() {
        return Subjects::findOne(['ID' => $this->SubjectID]);
    }

}
