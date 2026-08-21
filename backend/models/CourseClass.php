<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class CourseClass extends ActiveRecord
{
    public static function tableName()
    {
        return 'course_classes';
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
            ['code', 'match', 'pattern' => '/^[A-Z][A-Z0-9]{0,9}$/', 'message' => 'Kode harus berupa singkatan huruf atau angka, misalnya A atau NA.'],
            ['code', 'string', 'max' => 10],
            ['code', 'unique', 'message' => 'Kode kelas sudah digunakan.'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['code' => 'Kode Kelas', 'name' => 'Nama Kelas'];
    }
}
