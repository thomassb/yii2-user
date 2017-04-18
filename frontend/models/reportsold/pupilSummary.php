<?php

namespace frontend\models\reports;

use yii\base\Model;

class classSummary extends Model {

    public $className;
    public $pupilName;
    public $data;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [


            [['className'], 'required'],
            ['pupilName', 'string'],
            [['data', 'dateTo'], 'safe'],
        ];
    }

}

class _data {

    public $subject;
    public $strand;
    public $level = 'NA';

}
