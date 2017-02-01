<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Levels".
 *
 * @property integer $ID
 * @property string $LevelText
 *
 * @property Statements[] $statements
 */
class Levels extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Levels';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['LevelText'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'LevelText' => 'Level Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatements() {
        return $this->hasMany(Statements::className(), ['LevelID' => 'ID']);
    }

    public static function BaseLineLevels($StrandID, $pupilid, $subjectID, $displayall = false) {
        $baselevel = 0;
        if ($displayall === false) {
//levels all ready entered
            $l = \frontend\models\PupilStatements::find()->joinWith('statement')->where(['StrandID' => $StrandID, 'PupilID' => $pupilid])
                    ->orderBy(['LevelID' => SORT_DESC])->asArray()
                    ->one();
         
            $baselevelStatment = (isset($l['statement']['LevelID'])) ? $l['statement']['LevelID'] : 0;
            //completed level - dont display competed levels
            //count all statments

            $calLevel = \frontend\controllers\ReportController::PupilMaxLevel($pupilid, $subjectID, $StrandID);
            //echo $calLevel;
            $totalstatments = Statements::find()->where(['StrandID' => $StrandID, 'LevelID' => $calLevel])->count();
            $completedStatments = PupilStatements::find()->joinWith('statement')->where([ 'PupilID' => $pupilid, 'StrandID' => $StrandID, 'LevelID' => $calLevel])->andWhere(['not', ['ConsolidatedDate' => null]])->count();
            if ($totalstatments!=0&& $totalstatments == $completedStatments) {
                $calLevel++;
            }
     //   echo $totalstatments. ' '.$completedStatments."\n";
            //starting level
            $startinglevel = PupilStartingLevel::find()->where(['PupilID' => $pupilid, 'StrandID' => $StrandID])->one();
            $baselevelStarting = (isset($startinglevel->StartingLevel)) ? $startinglevel->StartingLevel : 0;
           
            if ($baselevelStatment > $baselevelStarting) {
                $baselevel = $baselevelStatment;
            } else {
                $baselevel = $baselevelStarting;
            }
            if ($baselevel < $calLevel) {
                $baselevel = $calLevel;
            }
        }
//echo $baselevelStatment.' '.$baselevelStarting.' '.$calLevel;

        $r = \frontend\models\Statements::find()->select(['LevelID'])->joinWith('levels')->where(['StrandID' => $StrandID])
                        ->andWhere(['>=', 'Levels.ID', $baselevel])
                        ->distinct()->all();
        return $r;
    }

}
