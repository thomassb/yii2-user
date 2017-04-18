<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Statements as StatementsModel;

/**
 * Statements represents the model behind the search form about `frontend\models\Statements`.
 */
class Statements extends StatementsModel {

   // public $SubjectID;
    public $displayAllLevels = 0;
    public $classID;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ID', 'StrandID', 'LevelID','SubjectID','PupilID','displayAllLevels'], 'integer'],
            [['StrandID', 'LevelID','SubjectID','PupilID'],'required'],
            [['StatementText'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = StatementsModel::find();

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
            'StrandID' => $this->StrandID,
            'LevelID' => $this->LevelID,
            //'PupilID' => $this->PupilID,
        ]);
        if ($this->PupilID != '') {
            $query->select(['Statements.*','PupilStatements.PupilID']);
            $query->leftJoin('PupilStatements', 'PupilStatements.StatementID=Statements.id and PupilID= :pid', [':pid' => $this->PupilID]);
        } else {
            $query->leftJoin('PupilStatements', 'PupilStatements.StatementID=Statements.id');
        }

        $query->andFilterWhere(['like', 'StatementText', $this->StatementText]);
        // $query->andFilterWhere(['StatementText', $this->StatementText]);

        return $dataProvider;
    }

}
