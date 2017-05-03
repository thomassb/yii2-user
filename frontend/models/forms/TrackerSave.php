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
        //If PupilStatementID is set we alrady have a row
        //find and update
        if (!$this->validate()) {
            return false;
        }
      
        
            
          $PupilStatement= PupilStatements::findOne(['StatementID'=>$this->StatementID,'PupilID'=>$this->PupilID]);//  $PupilStatement = \frontend\models\PupilStatements::findOne($this->PupilStatementID);
            if ($PupilStatement) {
                
                $PupilStatement->{$this->Type} = $this->value;
                return $PupilStatement->save();
                    
            } else {
            //we have to make a new record
                $NewPupilStatement = new PupilStatements();
                $NewPupilStatement->{$this->Type} = $this->value;
                $NewPupilStatement->StatementID = $this->StatementID;
                $NewPupilStatement->PupilID=$this->PupilID;
                return $NewPupilStatement->save();
            }
        
        
       
        return false;
    }

}
