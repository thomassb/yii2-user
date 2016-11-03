<?php

namespace frontend\models;

use Yii;
use common\models\Schools;
use frontend\models\Classes;
use common\models\Users;

/**
 * This is the model class for table "Pupils".
 *
 * @property integer $ID
 * @property string $FirstName
 * @property string $LastName
 * @property integer $ClassID
 * @property string $DoB
 * @property integer $UserID
 * @property integer $SchoolID
 * @property string $Created
 *
 * @property PupilStartingLevel[] $pupilStartingLevels
 * @property PupilStatements[] $pupilStatements
 * @property Schools $school
 * @property Classes $class
 * @property Users $user
 */
class Pupils extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'Pupils';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['FirstName', 'LastName', 'ClassID', 'DoB', 'UserID', 'SchoolID'], 'required'],
            [['ClassID', 'UserID', 'SchoolID'], 'integer'],
            [['DoB', 'Created'], 'safe'],
            [['FirstName', 'LastName'], 'string', 'max' => 250],
            [['SchoolID'], 'exist', 'skipOnError' => true, 'targetClass' => Schools::className(), 'targetAttribute' => ['SchoolID' => 'ID']],
            [['ClassID'], 'exist', 'skipOnError' => true, 'targetClass' => Classes::className(), 'targetAttribute' => ['ClassID' => 'ID']],
            [['UserID'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['UserID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => Yii::t('app', 'ID'),
            'FirstName' => Yii::t('app', 'First Name'),
            'LastName' => Yii::t('app', 'Last Name'),
            'ClassID' => Yii::t('app', 'Class'),
            'DoB' => Yii::t('app', 'Date of Birth'),
            'UserID' => Yii::t('app', 'User ID'),
            'SchoolID' => Yii::t('app', 'School ID'),
            'Created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupilStartingLevels() {
        return $this->hasMany(PupilStartingLevel::className(), ['PupilID' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPupilStatements() {
        return $this->hasMany(PupilStatements::className(), ['PupilID' => 'ID']);
    }
     public function getStatementList()
    {
        return $this->hasMany(PupilStatements::className(), ['PupilID' => 'ID'])
                ->joinWith(['statement'], true, 'INNER JOIN')
                ->andOnCondition('PupilID = '. $this->ID);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchool() {
        return $this->hasOne(Schools::className(), ['ID' => 'SchoolID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass() {
        return $this->hasOne(Classes::className(), ['ID' => 'ClassID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Users::className(), ['id' => 'UserID']);
    }

    public function getFullName() {
        return $this->FirstName . ' ' . $this->LastName;
    }

     public static function PupilList(){
        //TODO:: Add school variable 
        return Pupils::findAll(['SchoolID'=>2]);
    }

}
