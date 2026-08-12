<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class StructuralPosition extends ActiveRecord
{
    public static function tableName()
    {
        return 'structural_positions';
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
            ['code', 'match', 'pattern' => '/^\d{2,3}$/', 'message' => 'Kode harus terdiri dari 2 sampai 3 angka, misalnya 01 atau 011.'],
            ['code', 'string', 'min' => 2, 'max' => 3],
            ['code', 'unique', 'message' => 'Kode sudah digunakan.'],
            ['name', 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['code' => 'Kode', 'name' => 'Nama Jabatan Struktural'];
    }
}
