<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class FunctionalPositionSearch extends FunctionalPosition
{
    public function rules()
    {
        return [[['code', 'name'], 'safe']];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FunctionalPosition::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['code' => SORT_ASC]],
        ]);
        $this->load($params);
        if ($this->validate()) {
            $query->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'name', $this->name]);
        }
        return $provider;
    }
}
