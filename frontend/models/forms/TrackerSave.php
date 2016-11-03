<?php

namespace frontend\models\forms;

use yii\base\Model;
use frontend\models\PupilStatements;

/**
 * Signup form
 */
class TrackerSave extends Model {

    public $StatementID;
    public $PupilID;
    public $Type;
    public $PupilStatementID;
    public $value;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [


            [['StatementID', 'PupilID', 'Type'], 'required'],
            ['PupilStatementID', 'integer'],
            ['value', 'safe'],
            ['Type', 'in', 'range' => ['PartiallyDate', 'AchievedDate', 'ConsolidatedDate']]
        ];
    }

    public function save() {
        //If PupilStatmentID is set we alrady have a row
        //find and update
        if (!$this->validate()) {
            return false;
        }
      
        
            
          $PupilStatment= PupilStatements::findOne(['StatementID'=>$this->StatementID,'PupilID'=>$this->PupilID]);//  $PupilStatment = \frontend\models\PupilStatements::findOne($this->PupilStatementID);
            if ($PupilStatment) {
                
                $PupilStatment->{$this->Type} = $this->value;
                return $PupilStatment->save();
                    
            } else {
            //we have to make a new record
                $NewPupilStatment = new PupilStatements();
                $NewPupilStatment->{$this->Type} = $this->value;
                $NewPupilStatment->StatementID = $this->StatementID;
                $NewPupilStatment->PupilID=$this->PupilID;
                return $NewPupilStatment->save();
            }
        
        
       
        return false;
    }

}
