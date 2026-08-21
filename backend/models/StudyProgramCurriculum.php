<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class StudyProgramCurriculum extends ActiveRecord
{
    public static function tableName()
    {
        return 'study_program_curricula';
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
            [['study_program_id', 'curriculum_year_id', 'subject_id', 'semester', 'minimum_grade'], 'required'],
            [['study_program_id', 'curriculum_year_id', 'subject_id', 'semester', 'created_by', 'updated_by'], 'integer'],
            ['semester', 'integer', 'min' => 1, 'max' => 14],
            ['minimum_grade', 'in', 'range' => array_keys(self::gradeOptions())],
            [['is_mandatory', 'is_package'], 'boolean'],
            [['topic', 'basic_competencies'], 'string'],
            ['minimum_credits', 'number', 'min' => 0, 'max' => 999],
            [['study_program_id', 'curriculum_year_id', 'subject_id'], 'unique', 'targetAttribute' => ['study_program_id', 'curriculum_year_id', 'subject_id'], 'message' => 'Mata kuliah sudah terdaftar pada kurikulum prodi ini.'],
            ['study_program_id', 'exist', 'targetClass' => StudyProgram::class, 'targetAttribute' => ['study_program_id' => 'id']],
            ['curriculum_year_id', 'exist', 'targetClass' => CurriculumYear::class, 'targetAttribute' => ['curriculum_year_id' => 'id']],
            ['subject_id', 'exist', 'targetClass' => Subject::class, 'targetAttribute' => ['subject_id' => 'id']],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'study_program_id' => 'Program Studi', 'curriculum_year_id' => 'Tahun Kurikulum', 'subject_id' => 'Mata Kuliah',
            'semester' => 'Semester', 'minimum_grade' => 'Nilai Minimum', 'is_mandatory' => 'Mata Kuliah Wajib',
            'is_package' => 'Termasuk Paket', 'topic' => 'Topik', 'basic_competencies' => 'Kompetensi Dasar',
            'minimum_credits' => 'SKS Minimal',
        ];
    }

    public static function gradeOptions(): array
    {
        return ['A' => 'A', 'A-' => 'A-', 'B+' => 'B+', 'B' => 'B', 'B-' => 'B-', 'C+' => 'C+', 'C' => 'C', 'D' => 'D', 'E' => 'E'];
    }

    public function getStudyProgram() { return $this->hasOne(StudyProgram::class, ['id' => 'study_program_id']); }
    public function getCurriculumYear() { return $this->hasOne(CurriculumYear::class, ['id' => 'curriculum_year_id']); }
    public function getSubject() { return $this->hasOne(Subject::class, ['id' => 'subject_id']); }
}
