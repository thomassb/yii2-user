<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "SubjectAreas".
 *
 * @property integer $ID
 * @property integer $SubjectID
 * @property integer $AreaID
 *
 * @property Subjects $subject
 * @property Strands $area
 */
class SubjectAreas extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'SubjectAreas';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SubjectID', 'AreaID'], 'required'],
            [['SubjectID', 'AreaID', 'active'], 'integer'],
            [['SubjectID'], 'unique', 'targetAttribute' => ['SubjectID', 'AreaID'], 'message' => 'Strand already attched to subject.'],
            [['SubjectID'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['SubjectID' => 'ID']],
            [['AreaID'], 'exist', 'skipOnError' => true, 'targetClass' => Strands::className(), 'targetAttribute' => ['AreaID' => 'ID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'SubjectID' => 'Subject ID',
            'AreaID' => 'Area ID',
        ];
    }

    public static function find($active = true) {
        if ($active === true) {
            return parent::find()->where(['active' => 1]);
        } else {
            return parent::find();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject() {
        return $this->hasOne(Subjects::className(), ['ID' => 'SubjectID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea() {
        return $this->hasOne(Strands::className(), ['ID' => 'AreaID']);
    }

    public function delete($reallyDelete = false) {
        //Do i need to test
        if ($reallyDelete === true) {
            return parent::delete();
        } else {
            $this->active = 0;
            $this->save();
            return true;
        }
    }

}
