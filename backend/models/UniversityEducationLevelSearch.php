<?php
namespace backend\models;
use yii\base\Model; use yii\data\ActiveDataProvider;
class UniversityEducationLevelSearch extends UniversityEducationLevel
{
    public $education_level_name;
    public function rules() { return [[['education_level_id', 'study_period_semesters', 'max_leave_semesters', 'max_study_semesters'], 'integer'], [['education_level_name'], 'safe']]; }
    public function scenarios() { return Model::scenarios(); }
    public function search($params) { $query = UniversityEducationLevel::find()->joinWith('educationLevel'); $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['education_level_id' => SORT_ASC]]]); $this->load($params); if (!$this->validate()) return $provider; $query->andFilterWhere(['university_education_levels.education_level_id' => $this->education_level_id, 'study_period_semesters' => $this->study_period_semesters, 'max_leave_semesters' => $this->max_leave_semesters, 'max_study_semesters' => $this->max_study_semesters]); return $provider; }
}
