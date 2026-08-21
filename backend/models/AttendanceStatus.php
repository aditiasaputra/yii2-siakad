<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class AttendanceStatus extends ActiveRecord
{
    public static function tableName()
    {
        return 'attendance_statuses';
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
            ['code', 'match', 'pattern' => '/^[A-Z]{1,5}$/', 'message' => 'Kode harus berupa singkatan huruf, misalnya H atau I.'],
            ['code', 'string', 'max' => 5],
            ['code', 'unique', 'message' => 'Kode sudah digunakan.'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'string', 'max' => 100],
            [['counts_as_present', 'applies_to_lecturers', 'applies_to_students'], 'boolean'],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Kode',
            'name' => 'Nama Status Hadir',
            'counts_as_present' => 'Terhitung Hadir?',
            'applies_to_lecturers' => 'Berlaku untuk Dosen?',
            'applies_to_students' => 'Berlaku untuk Mahasiswa?',
        ];
    }
}
