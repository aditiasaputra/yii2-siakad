<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class AttendanceStatusSearch extends AttendanceStatus
{
    public function rules()
    {
        return [
            [['code', 'name'], 'safe'],
            [['counts_as_present', 'applies_to_lecturers', 'applies_to_students'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AttendanceStatus::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['code' => SORT_ASC]],
        ]);

        $this->load($params);
        if ($this->validate()) {
            $query->andFilterWhere([
                'counts_as_present' => $this->counts_as_present,
                'applies_to_lecturers' => $this->applies_to_lecturers,
                'applies_to_students' => $this->applies_to_students,
            ])->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'name', $this->name]);
        }

        return $provider;
    }
}
