<?php

namespace backend\models;

use yii\base\Model;
use common\models\Lecture;
use yii\data\ActiveDataProvider;

class LectureSearch extends Lecture
{

    public $name, $email, $lecture_nationality_number, $status, $gender, $created_at;

    public function rules()
    {
        return [
            [['name', 'email', 'lecture_nationality_number', 'status', 'gender'], 'string'],
            [['name', 'email', 'lecture_nationality_number', 'status', 'gender', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // skip parent implementation
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Lecture::find()->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['name'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['email'] = [
            'asc' => ['user.email' => SORT_ASC],
            'desc' => ['user.email' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['lecture_nationality_number'] = [
            'asc' => ['lecture_nationality_number' => SORT_ASC],
            'desc' => ['lecture_nationality_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['status'] = [
            'asc' => ['user.status' => SORT_ASC],
            'desc' => ['user.status' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['gender'] = [
            'asc' => ['user.gender' => SORT_ASC],
            'desc' => ['user.gender' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->created_at) && strpos($this->created_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $query->andFilterWhere([
                'between', 'user.created_at',
                date('Y-m-d 00:00:00', strtotime($start_date)),
                date('Y-m-d 23:59:59', strtotime($end_date))
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user.status' => $this->status,
            'user.gender' => $this->gender,
        ]);

        $query->andFilterWhere(['like', 'lecture_nationality_number',  $this->lecture_nationality_number])
            ->andFilterWhere(['like', 'user.name', $this->name])
            ->andFilterWhere(['like', 'user.email', $this->email]);

        return $dataProvider;
    }
}
