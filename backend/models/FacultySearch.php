<?php

namespace backend\models;

use yii\base\Model;
use backend\models\Faculty;
use yii\data\ActiveDataProvider;

/**
 * FacultySearch represents the model behind the search form of `app\models\Faculty`.
 */
class FacultySearch extends Faculty
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['unit_code', 'unit_name', 'unit_name_en', 'abbreviation', 'address', 'work_unit', 'phone', 'dean', 'vice_dean_1', 'vice_dean_2', 'vice_dean_3'], 'safe'],
            [['is_active'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Faculty::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'unit_code' => SORT_ASC,
                ]
            ],
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
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'unit_code', $this->unit_code])
            ->andFilterWhere(['like', 'unit_name', $this->unit_name])
            ->andFilterWhere(['like', 'unit_name_en', $this->unit_name_en])
            ->andFilterWhere(['like', 'abbreviation', $this->abbreviation])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'work_unit', $this->work_unit])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'dean', $this->dean])
            ->andFilterWhere(['like', 'vice_dean_1', $this->vice_dean_1])
            ->andFilterWhere(['like', 'vice_dean_2', $this->vice_dean_2])
            ->andFilterWhere(['like', 'vice_dean_3', $this->vice_dean_3]);

        return $dataProvider;
    }
}