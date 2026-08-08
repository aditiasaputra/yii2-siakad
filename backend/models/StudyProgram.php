<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class StudyProgram extends ActiveRecord
{
    public static function tableName()
    {
        return 'study_programs';
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
            [['code', 'name', 'short_name', 'name_en', 'program_type'], 'required'],
            [['faculty_id', 'capacity', 'nim_sequence_length', 'minimum_graduation_credits', 'created_by', 'updated_by'], 'integer'],
            [['allow_choice_1', 'allow_choice_2', 'allow_choice_3', 'is_active'], 'boolean'],
            [['capacity'], 'integer', 'min' => 0],
            [['nim_sequence_length'], 'integer', 'min' => 1, 'max' => 10],
            [['minimum_graduation_credits'], 'integer', 'min' => 0],
            [['minimum_graduation_gpa'], 'number', 'min' => 0, 'max' => 4],
            [['address'], 'string'],
            [['code', 'nim_prefix', 'phone', 'degree_abbreviation'], 'string', 'max' => 20],
            [['name', 'name_en', 'work_unit', 'head_of_program', 'secretary_of_program'], 'string', 'max' => 255],
            [['short_name'], 'string', 'max' => 50],
            [['program_type'], 'string', 'max' => 20],
            [['grade'], 'string', 'max' => 20], [['degree'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::class, 'targetAttribute' => ['faculty_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Kode Prodi', 'name' => 'Nama Prodi', 'short_name' => 'Nama Singkat', 'name_en' => 'Nama Prodi (EN)',
            'faculty_id' => 'Fakultas', 'program_type' => 'Tk. Pendidikan', 'work_unit' => 'Unit/Satuan Kerja',
            'phone' => 'Telepon', 'address' => 'Alamat', 'capacity' => 'Kuota', 'grade' => 'Akreditasi',
            'nim_prefix' => 'Kode NIM', 'nim_sequence_length' => 'Jml. Urut NIM',
            'head_of_program' => 'Ketua Prodi', 'secretary_of_program' => 'Sekretaris Prodi',
            'minimum_graduation_credits' => 'SKS Lulus Minimal', 'minimum_graduation_gpa' => 'IPK Lulus Minimal',
            'degree' => 'Gelar', 'degree_abbreviation' => 'Gelar (singkat)',
            'allow_choice_1' => 'Pilihan 1', 'allow_choice_2' => 'Pilihan 2', 'allow_choice_3' => 'Pilihan 3',
            'is_active' => 'Status',
        ];
    }

    public function getFaculty()
    {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getStatusBadge()
    {
        return '<span class="badge badge-' . ($this->is_active ? 'success' : 'secondary') . '">' . ($this->is_active ? 'Aktif' : 'Nonaktif') . '</span>';
    }
}
