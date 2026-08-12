<?php

namespace backend\models;

use common\models\Region;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RegionSearch extends Region
{
    public $searchLevel = 'province';

    public function formName()
    {
        return 'RegionSearch' . ucfirst($this->searchLevel);
    }

    public function rules()
    {
        return [[['kode', 'name', 'level', 'parent_kode'], 'safe']];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Region::find()->where(['level' => $this->searchLevel])->with('parent');
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20, 'pageParam' => $this->searchLevel . '-page'],
            'sort' => ['defaultOrder' => ['kode' => SORT_ASC], 'sortParam' => $this->searchLevel . '-sort'],
        ]);
        $this->load($params);
        if ($this->validate()) {
            $query->andFilterWhere(['like', 'kode', $this->kode])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['parent_kode' => $this->parent_kode]);
        }
        return $provider;
    }
}
