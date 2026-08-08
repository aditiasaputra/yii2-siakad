<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class StudyProgramSearch extends StudyProgram
{
    public $faculty_name;

    public function rules()
    {
        return [[['faculty_id'], 'integer'], [['code', 'name', 'short_name', 'program_type', 'work_unit', 'phone', 'grade', 'faculty_name'], 'safe'], [['is_active'], 'boolean']];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = StudyProgram::find()->joinWith('faculty');
        $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['code' => SORT_ASC]]]);
        $this->load($params);
        if (!$this->validate()) {
            return $provider;
        }
        $query->andFilterWhere(['study_programs.faculty_id' => $this->faculty_id, 'study_programs.is_active' => $this->is_active])
            ->andFilterWhere(['like', 'study_programs.code', $this->code])
            ->andFilterWhere(['like', 'study_programs.name', $this->name])
            ->andFilterWhere(['like', 'study_programs.short_name', $this->short_name])
            ->andFilterWhere(['like', 'study_programs.program_type', $this->program_type])
            ->andFilterWhere(['like', 'study_programs.work_unit', $this->work_unit])
            ->andFilterWhere(['like', 'study_programs.phone', $this->phone])
            ->andFilterWhere(['like', 'study_programs.grade', $this->grade])
            ->andFilterWhere(['like', 'faculties.unit_name', $this->faculty_name]);
        return $provider;
    }
}
