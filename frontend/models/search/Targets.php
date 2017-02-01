<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Targets as TargetsModel;

/**
 * Targets represents the model behind the search form about `frontend\models\Targets`.
 */
class Targets extends TargetsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'PupilID', 'year1Target', 'year1ReviewedTarget', 'year2Target', 'year2ReviewedTarget', 'year3Target', 'year3ReviewedTarget', 'year4Target', 'year4ReviewedTarget', 'year5Target', 'year5ReviewedTarget', 'year6Target', 'year6ReviewedTarget', 'year7Target', 'year8ReviewedTarget', 'year9Target', 'year9ReviewedTarget', 'year10Target', 'year10ReviewedTarget', 'year11Target', 'year11ReviewedTarget', 'year12Target', 'year12ReviewedTarget', 'year13Target', 'year13ReviewedTarget', 'year14Target', 'year14ReviewedTarget'], 'integer'],
            [['created'], 'safe'],
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
        $query = TargetsModel::find();

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
            'id' => $this->id,
            'PupilID' => $this->PupilID,
            'created' => $this->created,
            'year1Target' => $this->year1Target,
            'year1ReviewedTarget' => $this->year1ReviewedTarget,
            'year2Target' => $this->year2Target,
            'year2ReviewedTarget' => $this->year2ReviewedTarget,
            'year3Target' => $this->year3Target,
            'year3ReviewedTarget' => $this->year3ReviewedTarget,
            'year4Target' => $this->year4Target,
            'year4ReviewedTarget' => $this->year4ReviewedTarget,
            'year5Target' => $this->year5Target,
            'year5ReviewedTarget' => $this->year5ReviewedTarget,
            'year6Target' => $this->year6Target,
            'year6ReviewedTarget' => $this->year6ReviewedTarget,
            'year7Target' => $this->year7Target,
            'year8ReviewedTarget' => $this->year8ReviewedTarget,
            'year9Target' => $this->year9Target,
            'year9ReviewedTarget' => $this->year9ReviewedTarget,
            'year10Target' => $this->year10Target,
            'year10ReviewedTarget' => $this->year10ReviewedTarget,
            'year11Target' => $this->year11Target,
            'year11ReviewedTarget' => $this->year11ReviewedTarget,
            'year12Target' => $this->year12Target,
            'year12ReviewedTarget' => $this->year12ReviewedTarget,
            'year13Target' => $this->year13Target,
            'year13ReviewedTarget' => $this->year13ReviewedTarget,
            'year14Target' => $this->year14Target,
            'year14ReviewedTarget' => $this->year14ReviewedTarget,
        ]);

        return $dataProvider;
    }
    public function deleteOldAttributes(){
        $this->oldAttributes = [];
    }
}
