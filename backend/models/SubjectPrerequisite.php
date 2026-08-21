<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class SubjectPrerequisite extends ActiveRecord
{
    public static function tableName()
    {
        return 'subject_prerequisites';
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
            [['course_curriculum_id', 'prerequisite_curriculum_id', 'requirement_type'], 'required'],
            [['course_curriculum_id', 'prerequisite_curriculum_id', 'created_by', 'updated_by'], 'integer'],
            ['requirement_type', 'in', 'range' => array_keys(self::typeOptions())],
            ['minimum_grade', 'in', 'range' => array_merge([''], array_keys(StudyProgramCurriculum::gradeOptions()))],
            ['prerequisite_curriculum_id', 'compare', 'compareAttribute' => 'course_curriculum_id', 'operator' => '!=', 'message' => 'Mata kuliah tidak dapat menjadi prasyarat untuk dirinya sendiri.'],
            [['course_curriculum_id', 'prerequisite_curriculum_id'], 'unique', 'targetAttribute' => ['course_curriculum_id', 'prerequisite_curriculum_id'], 'message' => 'Relasi prasyarat tersebut sudah tersedia.'],
            ['course_curriculum_id', 'exist', 'targetClass' => StudyProgramCurriculum::class, 'targetAttribute' => ['course_curriculum_id' => 'id']],
            ['prerequisite_curriculum_id', 'exist', 'targetClass' => StudyProgramCurriculum::class, 'targetAttribute' => ['prerequisite_curriculum_id' => 'id']],
            ['prerequisite_curriculum_id', 'validateSameCurriculum'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function validateSameCurriculum($attribute)
    {
        if ($this->hasErrors()) { return; }
        $course = StudyProgramCurriculum::findOne($this->course_curriculum_id);
        $prerequisite = StudyProgramCurriculum::findOne($this->prerequisite_curriculum_id);
        if (!$course || !$prerequisite || $course->study_program_id !== $prerequisite->study_program_id || $course->curriculum_year_id !== $prerequisite->curriculum_year_id) {
            $this->addError($attribute, 'Mata kuliah dan prasyarat harus berasal dari prodi serta kurikulum yang sama.');
        }
    }

    public function attributeLabels()
    {
        return ['course_curriculum_id' => 'Mata Kuliah', 'prerequisite_curriculum_id' => 'Prasyarat', 'requirement_type' => 'Jenis', 'minimum_grade' => 'Nilai Minimum'];
    }

    public static function typeOptions(): array
    {
        return ['passed' => 'Lulus', 'concurrent' => 'Sedang Ditempuh'];
    }

    public function getCourseCurriculum() { return $this->hasOne(StudyProgramCurriculum::class, ['id' => 'course_curriculum_id']); }
    public function getPrerequisiteCurriculum() { return $this->hasOne(StudyProgramCurriculum::class, ['id' => 'prerequisite_curriculum_id']); }
}
