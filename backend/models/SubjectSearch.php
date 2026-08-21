<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SubjectSearch extends Subject
{
    public function rules()
    {
        return [
            [['code', 'name'], 'safe'],
            [['curriculum_year_id', 'subject_type_id', 'subject_group_id', 'study_program_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Subject::find()->with(['curriculumYear', 'subjectType', 'subjectGroup', 'studyProgram']);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['code' => SORT_ASC]],
        ]);
        $this->load($params);
        if ($this->validate()) {
            $query->andFilterWhere([
                'curriculum_year_id' => $this->curriculum_year_id,
                'subject_type_id' => $this->subject_type_id,
                'subject_group_id' => $this->subject_group_id,
                'study_program_id' => $this->study_program_id,
            ])->andFilterWhere(['or', ['like', 'code', $this->code], ['like', 'name', $this->name]]);
        }
        return $provider;
    }
}
