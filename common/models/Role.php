<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Role model
 *
 * @property integer $id
 * @property string $name
 */
class Role extends ActiveRecord
{
    /**
     * Get users
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['role' => 'role']);
    }
}