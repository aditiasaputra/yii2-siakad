<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class LectureRoom extends ActiveRecord
{
    public static function tableName()
    {
        return 'lecture_rooms';
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
            [['study_program_id', 'code', 'name', 'location', 'capacity'], 'required'],
            [['study_program_id', 'capacity', 'created_by', 'updated_by'], 'integer'],
            [['capacity'], 'integer', 'min' => 1],
            [['is_active'], 'boolean'],
            [['code'], 'match', 'pattern' => '/^\d+$/', 'message' => 'Kode harus berupa angka.'],
            [['code'], 'string', 'max' => 20],
            [['name', 'location'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['study_program_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudyProgram::class, 'targetAttribute' => ['study_program_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function getStudyProgram()
    {
        return $this->hasOne(StudyProgram::class, ['id' => 'study_program_id']);
    }

    public function attributeLabels()
    {
        return ['code' => 'Kode', 'name' => 'Nama Ruang', 'study_program_id' => 'Unit', 'location' => 'Lokasi', 'capacity' => 'Kapasitas', 'is_active' => 'Aktif'];
    }
}
