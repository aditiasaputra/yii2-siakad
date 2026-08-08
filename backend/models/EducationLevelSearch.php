<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class EducationLevelSearch extends EducationLevel
{
    public function rules()
    {
        return [[['sort_order'], 'integer'], [['level', 'name'], 'safe'], [['is_university'], 'boolean']];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EducationLevel::find();
        $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['sort_order' => SORT_ASC]]]);
        $this->load($params);
        if (!$this->validate()) {
            return $provider;
        }
        $query->andFilterWhere(['sort_order' => $this->sort_order, 'is_university' => $this->is_university])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'name', $this->name]);
        return $provider;
    }
}
