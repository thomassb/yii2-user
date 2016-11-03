<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PupilStatements as PupilStatementsModel;

/**
 * PupilStatements represents the model behind the search form about `frontend\models\PupilStatements`.
 */
class PupilStatements extends PupilStatementsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PupilID', 'StatementID'], 'integer'],
            [['PartiallyDate', 'AchievedDate', 'ConsolidatedDate'], 'safe'],
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
        $query = PupilStatementsModel::find();

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
            'StatementID' => $this->StatementID,
            'PartiallyDate' => $this->PartiallyDate,
            'AchievedDate' => $this->AchievedDate,
            'ConsolidatedDate' => $this->ConsolidatedDate,
        ]);

        return $dataProvider;
    }
}
