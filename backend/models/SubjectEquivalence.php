<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class SubjectEquivalence extends ActiveRecord
{
    public static function tableName()
    {
        return 'subject_equivalences';
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
            [['study_program_id', 'new_curriculum_year_id', 'old_curriculum_year_id', 'new_subject_id', 'old_subject_id'], 'required'],
            [['study_program_id', 'new_curriculum_year_id', 'old_curriculum_year_id', 'new_subject_id', 'old_subject_id', 'created_by', 'updated_by'], 'integer'],
            ['old_curriculum_year_id', 'compare', 'compareAttribute' => 'new_curriculum_year_id', 'operator' => '!=', 'message' => 'Kurikulum lama dan baru harus berbeda.'],
            [['new_subject_id', 'old_subject_id'], 'unique', 'targetAttribute' => ['new_subject_id', 'old_subject_id'], 'message' => 'Pasangan ekivalensi tersebut sudah tersedia.'],
            ['study_program_id', 'exist', 'targetClass' => StudyProgram::class, 'targetAttribute' => ['study_program_id' => 'id']],
            ['new_curriculum_year_id', 'exist', 'targetClass' => CurriculumYear::class, 'targetAttribute' => ['new_curriculum_year_id' => 'id']],
            ['old_curriculum_year_id', 'exist', 'targetClass' => CurriculumYear::class, 'targetAttribute' => ['old_curriculum_year_id' => 'id']],
            ['new_subject_id', 'exist', 'targetClass' => Subject::class, 'targetAttribute' => ['new_subject_id' => 'id']],
            ['old_subject_id', 'exist', 'targetClass' => Subject::class, 'targetAttribute' => ['old_subject_id' => 'id']],
            ['old_subject_id', 'validateSubjectContexts'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function validateSubjectContexts($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }
        $newSubject = Subject::findOne($this->new_subject_id);
        $oldSubject = Subject::findOne($this->old_subject_id);
        if (!$newSubject || $newSubject->study_program_id != $this->study_program_id || $newSubject->curriculum_year_id != $this->new_curriculum_year_id) {
            $this->addError('new_subject_id', 'Mata kuliah baru tidak sesuai dengan prodi dan kurikulum baru.');
        }
        if (!$oldSubject || $oldSubject->study_program_id != $this->study_program_id || $oldSubject->curriculum_year_id != $this->old_curriculum_year_id) {
            $this->addError($attribute, 'Mata kuliah lama tidak sesuai dengan prodi dan kurikulum lama.');
        }
    }

    public function attributeLabels()
    {
        return [
            'study_program_id' => 'Prodi', 'new_curriculum_year_id' => 'Kurikulum Baru',
            'old_curriculum_year_id' => 'Kurikulum Lama', 'new_subject_id' => 'Mata Kuliah Kurikulum Baru',
            'old_subject_id' => 'Mata Kuliah Kurikulum Lama',
        ];
    }

    public function getStudyProgram() { return $this->hasOne(StudyProgram::class, ['id' => 'study_program_id']); }
    public function getNewCurriculumYear() { return $this->hasOne(CurriculumYear::class, ['id' => 'new_curriculum_year_id']); }
    public function getOldCurriculumYear() { return $this->hasOne(CurriculumYear::class, ['id' => 'old_curriculum_year_id']); }
    public function getNewSubject() { return $this->hasOne(Subject::class, ['id' => 'new_subject_id']); }
    public function getOldSubject() { return $this->hasOne(Subject::class, ['id' => 'old_subject_id']); }
}
