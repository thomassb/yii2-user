<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PupilStartingLevel as PupilStartingLevelModel;

/**
 * PupilStartingLevel represents the model behind the search form about `frontend\models\PupilStartingLevel`.
 */
class PupilStartingLevel extends PupilStartingLevelModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PupilID', 'StrandID', 'StartingLevel'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PupilStartingLevelModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'PupilID' => $this->PupilID,
            'StrandID' => $this->StrandID,
            'StartingLevel' => $this->StartingLevel,
        ]);

        return $dataProvider;
    }
}
