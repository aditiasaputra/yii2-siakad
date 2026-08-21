<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class CurriculumYearSearch extends CurriculumYear
{
    public function rules()
    {
        return [
            ['year', 'integer'],
            ['description', 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CurriculumYear::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['year' => SORT_DESC]],
        ]);

        $this->load($params);
        if ($this->validate()) {
            $query->andFilterWhere(['year' => $this->year])
                ->andFilterWhere(['like', 'description', $this->description]);
        }

        return $provider;
    }
}
