<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class LectureRoomSearch extends LectureRoom
{
    public function rules()
    {
        return [[['study_program_id', 'capacity'], 'integer'], [['code', 'name', 'location'], 'safe'], [['is_active'], 'boolean']];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = LectureRoom::find()->joinWith('studyProgram');
        $provider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20], 'sort' => ['defaultOrder' => ['code' => SORT_ASC]]]);
        $this->load($params);
        if (!$this->validate()) {
            return $provider;
        }
        $query->andFilterWhere(['lecture_rooms.study_program_id' => $this->study_program_id, 'lecture_rooms.capacity' => $this->capacity, 'lecture_rooms.is_active' => $this->is_active])
            ->andFilterWhere(['like', 'lecture_rooms.code', $this->code])
            ->andFilterWhere(['like', 'lecture_rooms.name', $this->name])
            ->andFilterWhere(['like', 'lecture_rooms.location', $this->location]);
        return $provider;
    }
}
