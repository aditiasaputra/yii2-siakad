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
    public static function tableName()
    {
        return '{{%roles}}';
    }

    /**
     * Get users
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }
}
