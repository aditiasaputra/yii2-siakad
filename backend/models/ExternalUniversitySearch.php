<?php
namespace backend\models;
use yii\base\Model; use yii\data\ActiveDataProvider;
class ExternalUniversitySearch extends ExternalUniversity { public function rules() { return [[['code', 'name', 'address', 'phone'], 'safe']]; } public function scenarios() { return Model::scenarios(); } public function search($params) { $query = ExternalUniversity::find(); $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['code' => SORT_ASC]]]); $this->load($params); if (!$this->validate()) return $provider; $query->andFilterWhere(['like', 'code', $this->code])->andFilterWhere(['like', 'name', $this->name])->andFilterWhere(['like', 'address', $this->address])->andFilterWhere(['like', 'phone', $this->phone]); return $provider; } }
