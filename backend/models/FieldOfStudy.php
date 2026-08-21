<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class FieldOfStudy extends ActiveRecord
{
    public static function tableName()
    {
        return 'fields_of_study';
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
            ['code', 'match', 'pattern' => '/^[A-Z][A-Z0-9]{1,9}$/', 'message' => 'Kode harus berupa singkatan huruf atau angka, misalnya ACC1 atau FINC.'],
            ['code', 'string', 'max' => 10],
            ['code', 'unique', 'message' => 'Kode sudah digunakan.'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['code' => 'Kode', 'name' => 'Nama Bidang Ilmu'];
    }
}
