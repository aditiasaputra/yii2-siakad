<?php

namespace backend\models;

use common\models\Lecture;
use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Subject extends ActiveRecord
{
    public $lecturer_ids = [];
    public $syllabus_upload;
    public $material_details_upload;

    public static function tableName()
    {
        return 'subjects';
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
            [['curriculum_year_id', 'code', 'name', 'subject_type_id', 'subject_group_id', 'study_program_id', 'credits'], 'required'],
            [['curriculum_year_id', 'subject_type_id', 'subject_group_id', 'study_program_id', 'created_by', 'updated_by'], 'integer'],
            [['credits', 'face_to_face_credits', 'practicum_credits', 'lab_credits', 'ksk_credits', 'pbl_credits'], 'number', 'min' => 0, 'max' => 99],
            [['code'], 'string', 'max' => 30],
            [['name', 'name_en', 'mku', 'sap', 'syllabus', 'teaching_material', 'module'], 'string', 'max' => 255],
            [['syllabus_file', 'material_details_file'], 'string', 'max' => 255],
            [['syllabus_upload', 'material_details_upload'], 'file', 'skipOnEmpty' => true, 'extensions' => ['pdf', 'doc', 'docx', 'odt', 'xls', 'xlsx', 'ppt', 'pptx'], 'checkExtensionByMimeType' => true, 'maxSize' => 10 * 1024 * 1024],
            ['code', 'filter', 'filter' => static fn($value) => strtoupper(trim($value))],
            [['lecturer_ids'], 'each', 'rule' => ['integer']],
            [['curriculum_year_id', 'code'], 'unique', 'targetAttribute' => ['curriculum_year_id', 'code'], 'message' => 'Kode sudah digunakan pada tahun kurikulum tersebut.'],
            ['curriculum_year_id', 'exist', 'targetClass' => CurriculumYear::class, 'targetAttribute' => ['curriculum_year_id' => 'id']],
            ['subject_type_id', 'exist', 'targetClass' => SubjectType::class, 'targetAttribute' => ['subject_type_id' => 'id']],
            ['subject_group_id', 'exist', 'targetClass' => SubjectGroup::class, 'targetAttribute' => ['subject_group_id' => 'id']],
            ['study_program_id', 'exist', 'targetClass' => StudyProgram::class, 'targetAttribute' => ['study_program_id' => 'id']],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'curriculum_year_id' => 'Tahun Kurikulum', 'code' => 'Kode Mata Kuliah', 'name' => 'Nama Mata Kuliah',
            'name_en' => 'Nama Mata Kuliah (EN)', 'subject_type_id' => 'Jenis Mata Kuliah',
            'subject_group_id' => 'Kelompok Mata Kuliah', 'study_program_id' => 'Unit / Prodi Pengampu',
            'credits' => 'SKS', 'face_to_face_credits' => 'SKS Tatap Muka', 'practicum_credits' => 'SKS Praktikum',
            'lab_credits' => 'SKS Skills Lab', 'ksk_credits' => 'SKS KSK', 'pbl_credits' => 'SKS PBL',
            'lecturer_ids' => 'Dosen Pengampu', 'mku' => 'MKU', 'sap' => 'SAP', 'syllabus' => 'Silabus',
            'teaching_material' => 'Bahan Ajar', 'module' => 'Diktat', 'syllabus_upload' => 'File Silabus Mata Kuliah',
            'material_details_upload' => 'File Rincian Materi',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->lecturer_ids = $this->getLecturers()->select('lectures.id')->column();
    }

    public function getCurriculumYear() { return $this->hasOne(CurriculumYear::class, ['id' => 'curriculum_year_id']); }
    public function getSubjectType() { return $this->hasOne(SubjectType::class, ['id' => 'subject_type_id']); }
    public function getSubjectGroup() { return $this->hasOne(SubjectGroup::class, ['id' => 'subject_group_id']); }
    public function getStudyProgram() { return $this->hasOne(StudyProgram::class, ['id' => 'study_program_id']); }
    public function getLecturers() { return $this->hasMany(Lecture::class, ['id' => 'lecturer_id'])->viaTable('subject_lecturers', ['subject_id' => 'id']); }
}
