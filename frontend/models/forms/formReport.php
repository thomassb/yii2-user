<?php

namespace frontend\models\forms;

use yii\base\Model;
use \frontend\models\Pupils;
use \frontend\models\Classes;
use \frontend\models\Subjects;

/**
 * Signup form
 */
class formReport extends Model {

    public $useDate;
    public $dateFrom;
    public $dateTo;
    public $classID;
    public $PupilID;
    public $pupilIDAjax, $pupilIDClass;
    public $subjectID;
    public $_daterange;
    public $perpage;
    public $strandID;
    public $displayAllLevels;
    public $levelID;
    public $displayAllStatments;
    public $PupilPremium;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [


            [['useDate'], 'required'],
            [['classID', 'PupilID', 'pupilIDAjax', 'pupilIDClass', 'subjectID', 'displayAllLevels','displayAllStatments','PupilPremium'], 'integer'],
            [['dateFrom', 'dateTo', '_daterange'], 'safe'],
        ];
    }

    public function load($data, $formName = null) {
        if (parent::load($data, $formName) === false) {
            return false;
        } else {

            if ($this->PupilID == '') {
                $this->PupilID = NULL;
            }
            if ($this->classID == '') {
                $this->classID = NULL;
            }
            if ($this->subjectID == '') {
                $this->subjectID = NULL;
            }
            if ($this->displayAllLevels == '') {
                $this->displayAllLevels = false;
            }
           
//                if ($this->pupilIDAjax) {
//                    $this->pupilID = $this->pupilIDAjax;
//                } elseif ($this->pupilIDClass) {
//                    $this->pupilID = $this->pupilIDClass;
//                }
            
                $this->pupilIDAjax = $this->PupilID;
                $this->pupilIDClass = $this->PupilID;
            
            $_date = explode(' - ', $this->_daterange);
            if (count($_date) == 2) {
                $this->dateFrom = $_date[0];
                $this->dateTo = $_date[1];
            }
            return true;
        }
    }

    public function getClass() {
        $r = Classes::findOne(['ID' => $this->classID]);
        return ($r) ? $r : new Classes();
    }

    public function getPupil() {
        $r = Pupils::findOne(['ID' => $this->PupilID]);
        return ($r) ? $r : new Pupils();
    }

    public function getSubject() {
        $r = Subjects::findOne(['ID' => $this->subjectID]);
        return ($r) ? $r : new Subjects();
    }

    public function NiceFilterName() {
        $niceFilter = "";
        if ($this->classID) {
            $niceFilter.="Class: {$this->class->ClassName} ";
        }
        if ($this->PupilID) {
            $niceFilter.="Pupil: {$this->pupil->FullName} ";
        }
        if ($this->subjectID) {
            $niceFilter.="Subject: {$this->subject->Subject} ";
        }
        if ($this->_daterange) {
            $niceFilter.="Date Range:  {$this->dateFrom} to  {$this->dateTo}";
        }
        return trim($niceFilter);
    }

}
