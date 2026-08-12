<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Rank extends ActiveRecord
{
    public static function tableName()
    {
        return 'ranks';
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
            ['code', 'filter', 'filter' => static fn($value) => preg_replace('/\s+/', ' ', strtoupper(trim($value)))],
            ['code', 'match', 'pattern' => '/^(I|II|III|IV) [A-E]$/', 'message' => 'Pangkat harus menggunakan format seperti I A, III B, atau IV E.'],
            ['code', 'string', 'max' => 10],
            ['code', 'unique', 'message' => 'Pangkat sudah digunakan.'],
            ['name', 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['code' => 'Pangkat', 'name' => 'Nama Golongan'];
    }
}
