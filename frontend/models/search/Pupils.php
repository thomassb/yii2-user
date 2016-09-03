<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pupils as PupilsModel;

/**
 * Pupils represents the model behind the search form about `common\models\Pupils`.
 */
class Pupils extends PupilsModel {

    public $ClassName;
     public $SchoolName;
      public $UserName;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ID', 'ClassID', 'UserID', 'SchoolID'], 'integer'],
            [['FirstName', 'LastName', 'DoB', 'Created', 'ClassName'], 'safe'],
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
        $query = PupilsModel::find();
        $query->joinWith(['class']);

        // add conditions that should always apply here
// TODO: This should be limit the search to school or user level...

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['ClassName'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => [\common\models\Classes::tableName() . '.classname' => SORT_ASC],
            'desc' => [\common\models\Classes::tableName() . '.classname' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'ClassID' => $this->ClassID,
            'DoB' => $this->DoB,
            'UserID' => $this->UserID,
            'SchoolID' => $this->SchoolID,
            'Created' => $this->Created,
        ]);

        $query->andFilterWhere(['like', 'FirstName', $this->FirstName])
                ->andFilterWhere(['like', 'LastName', $this->LastName])
                ->andFilterWhere(['like', \common\models\Classes::tableName() . '.classname', $this->ClassName])
        ;

        return $dataProvider;
    }

}
