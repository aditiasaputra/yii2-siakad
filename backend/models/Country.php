<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Country extends ActiveRecord
{
    public static function tableName()
    {
        return 'countries';
    }

    public function behaviors()
    {
        return [
            ['class' => TimestampBehavior::class, 'value' => new Expression('NOW()')],
            BlameableBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            ['code', 'filter', 'filter' => static fn($value) => strtoupper(trim($value))],
            ['code', 'match', 'pattern' => '/^[A-Z]{3}$/', 'message' => 'Kode harus terdiri dari 3 huruf, misalnya IDN.'],
            ['code', 'string', 'length' => 3],
            ['code', 'unique', 'message' => 'Kode sudah digunakan.'],
            ['name', 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['code' => 'Kode', 'name' => 'Nama Negara'];
    }
}
