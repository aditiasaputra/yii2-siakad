<?php
namespace backend\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ConcentrationSearch extends Concentration
{
    public $study_program_name;
    public function rules() { return [[['study_program_id'], 'integer'], [['code', 'name', 'name_en', 'study_program_name'], 'safe']]; }
    public function scenarios() { return Model::scenarios(); }
    public function search($params) { $query = Concentration::find()->joinWith('studyProgram'); $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['code' => SORT_ASC]]]); $this->load($params); if (!$this->validate()) return $provider; $query->andFilterWhere(['concentrations.study_program_id' => $this->study_program_id])->andFilterWhere(['like', 'concentrations.code', $this->code])->andFilterWhere(['like', 'concentrations.name', $this->name])->andFilterWhere(['like', 'concentrations.name_en', $this->name_en]); return $provider; }
}
