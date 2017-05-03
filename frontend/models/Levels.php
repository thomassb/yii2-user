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
      //  $displayall=true;
        if ($displayall === false) {
//levels all ready entered
//            $l = \frontend\models\PupilStatements::find()->joinWith('statement')->andFilterWhere
//                            (['StrandID' => $StrandID, 'PupilID' => $pupilid])
//                    ->andFilterWhere(['or',
//                        ['not', ['PartiallyDate' => 'null']],
//                        ['not', ['AchievedDate' => 'null']],
//                        ['not', ['ConsolidatedDate' => 'null']],
//                    ])
//                    // ->andFilterWhere(['or','PartiallyDate' => null,'AchievedDate'=> null,'ConsolidatedDate'=> null])
//                    ->orderBy(['LevelID' => SORT_DESC])->asArray()
//                    ->one();

            $baselevelStatement = (isset($l['statement']['LevelID'])) ? $l['statement']['LevelID'] : 0;
            
            
            //completed level - dont display competed levels
            //count all statements

            $calLevel = \frontend\controllers\ReportController::PupilMaxLevel($pupilid, $subjectID, $StrandID);
         //  echo $pupilid, $subjectID, $StrandID , $calLevel;
//            $totalstatements = Statements::find()->where(['StrandID' => $StrandID, 'LevelID' => $calLevel])->count();
//            $completedStatements = PupilStatements::find()->joinWith('statement')->where([ 'PupilID' => $pupilid, 'StrandID' => $StrandID, 'LevelID' => $calLevel])->andWhere(['not', ['ConsolidatedDate' => null]])->count();
//            if ($totalstatements != 0 && $totalstatements == $completedStatements) {
              
//            }
            //   echo $totalstatements. ' '.$completedStatements."\n";
            //starting level
            $startinglevel = PupilStartingLevel::find()->where(['PupilID' => $pupilid, 'StrandID' => $StrandID])->one();
            $baselevelStarting = (isset($startinglevel->StartingLevel)) ? $startinglevel->StartingLevel+1 : 0;

            if ($baselevelStatement > $baselevelStarting) {
                $baselevel = $baselevelStatement;
            } else {
                $baselevel = $baselevelStarting;
            }
           
            if ($baselevel < $calLevel) {
                $baselevel = $calLevel;
            }
        }
      //  print_r($baselevelStatement);

//echo $baselevelStatement.' '.$baselevelStarting.' '.$calLevel;

        $r = \frontend\models\Statements::find()->select(['LevelID'])->joinWith('levels')->where(['StrandID' => $StrandID])
                        ->andWhere(['>=', 'Levels.ID', $baselevel])
                        ->distinct()->all();
        return $r;
    }

}
