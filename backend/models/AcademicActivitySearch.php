<?php
namespace backend\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
class AcademicActivitySearch extends AcademicActivity
{
    public function rules() { return [[['code', 'name', 'background'], 'safe']]; }
    public function scenarios() { return Model::scenarios(); }
    public function search($params)
    {
        $query = AcademicActivity::find();
        $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['code' => SORT_ASC]]]);
        $this->load($params);
        if (!$this->validate()) return $provider;
        $query->andFilterWhere(['like', 'code', $this->code])->andFilterWhere(['like', 'name', $this->name])->andFilterWhere(['like', 'background', $this->background]);
        return $provider;
    }
}
