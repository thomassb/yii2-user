<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Targets".
 *
 * @property integer $id
 * @property integer $PupilID
 *  @property integer $StrandID
 * @property string $created
 * @property integer $year1Target
 * @property integer $year1ReviewedTarget
 * @property integer $year2Target
 * @property integer $year2ReviewedTarget
 * @property integer $year3Target
 * @property integer $year3ReviewedTarget
 * @property integer $year4Target
 * @property integer $year4ReviewedTarget
 * @property integer $year5Target
 * @property integer $year5ReviewedTarget
 * @property integer $year6Target
 * @property integer $year6ReviewedTarget
 * @property integer $year7Target
 * @property integer $year8ReviewedTarget
 * @property integer $year9Target
 * @property integer $year9ReviewedTarget
 * @property integer $year10Target
 * @property integer $year10ReviewedTarget
 * @property integer $year11Target
 * @property integer $year11ReviewedTarget
 * @property integer $year12Target
 * @property integer $year12ReviewedTarget
 * @property integer $year13Target
 * @property integer $year13ReviewedTarget
 * @property integer $year14Target
 * @property integer $year14ReviewedTarget
 */
class Targets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Targets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PupilID', 'StrandID'], 'required'],
            [['PupilID', 'year1Target', 'year1ReviewedTarget', 'year2Target', 'year2ReviewedTarget', 'year3Target', 'year3ReviewedTarget', 'year4Target', 'year4ReviewedTarget', 'year5Target', 'year5ReviewedTarget', 'year6Target', 'year6ReviewedTarget', 'year7Target', 'year8ReviewedTarget', 'year9Target', 'year9ReviewedTarget', 'year10Target', 'year10ReviewedTarget', 'year11Target', 'year11ReviewedTarget', 'year12Target', 'year12ReviewedTarget', 'year13Target', 'year13ReviewedTarget', 'year14Target', 'year14ReviewedTarget'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'PupilID' => Yii::t('app', 'Pupil ID'),
            'created' => Yii::t('app', 'Created'),
            'year1Target' => Yii::t('app', 'Year1 Target'),
            'year1ReviewedTarget' => Yii::t('app', 'Year1 Reviewed Target'),
            'year2Target' => Yii::t('app', 'Year2 Target'),
            'year2ReviewedTarget' => Yii::t('app', 'Year2 Reviewed Target'),
            'year3Target' => Yii::t('app', 'Year3 Target'),
            'year3ReviewedTarget' => Yii::t('app', 'Year3 Reviewed Target'),
            'year4Target' => Yii::t('app', 'Year4 Target'),
            'year4ReviewedTarget' => Yii::t('app', 'Year4 Reviewed Target'),
            'year5Target' => Yii::t('app', 'Year5 Target'),
            'year5ReviewedTarget' => Yii::t('app', 'Year5 Reviewed Target'),
            'year6Target' => Yii::t('app', 'Year6 Target'),
            'year6ReviewedTarget' => Yii::t('app', 'Year6 Reviewed Target'),
            'year7Target' => Yii::t('app', 'Year7 Target'),
            'year8ReviewedTarget' => Yii::t('app', 'Year8 Reviewed Target'),
            'year9Target' => Yii::t('app', 'Year9 Target'),
            'year9ReviewedTarget' => Yii::t('app', 'Year9 Reviewed Target'),
            'year10Target' => Yii::t('app', 'Year10 Target'),
            'year10ReviewedTarget' => Yii::t('app', 'Year10 Reviewed Target'),
            'year11Target' => Yii::t('app', 'Year11 Target'),
            'year11ReviewedTarget' => Yii::t('app', 'Year11 Reviewed Target'),
            'year12Target' => Yii::t('app', 'Year12 Target'),
            'year12ReviewedTarget' => Yii::t('app', 'Year12 Reviewed Target'),
            'year13Target' => Yii::t('app', 'Year13 Target'),
            'year13ReviewedTarget' => Yii::t('app', 'Year13 Reviewed Target'),
            'year14Target' => Yii::t('app', 'Year14 Target'),
            'year14ReviewedTarget' => Yii::t('app', 'Year14 Reviewed Target'),
        ];
    }
}
