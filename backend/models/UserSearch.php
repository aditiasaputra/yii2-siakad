<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends User
{
    public $id, $name, $username, $email, $status, $role_id;
    public function rules(): array
    {
        return [
            [['id', 'status', 'role_id'], 'integer'],
            [['name', 'username', 'email', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // skip parent implementation
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find()->joinWith(['role']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->created_at) && strpos($this->created_at, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at);
            $query->andFilterWhere([
                'between', 'users.created_at',
                date('Y-m-d 00:00:00', strtotime($start_date)),
                date('Y-m-d 23:59:59', strtotime($end_date))
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'role_id' => $this->role_id,
        ]);

        $query->andFilterWhere(['like', 'users.name', $this->name])
            ->andFilterWhere(['like', 'users.username', $this->username])
            ->andFilterWhere(['like', 'users.email', $this->email]);

        return $dataProvider;
    }
}
