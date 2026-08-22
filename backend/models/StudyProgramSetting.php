<?php
namespace backend\models;
use common\models\User;use yii\behaviors\{BlameableBehavior,TimestampBehavior};use yii\db\{ActiveRecord,Expression};
class StudyProgramSetting extends ActiveRecord
{
    public static function tableName(){return 'study_program_settings';}
    public function behaviors(){return [['class'=>TimestampBehavior::class,'value'=>new Expression('NOW()')],BlameableBehavior::class];}
    public function rules(){return [[['academic_period','study_program_id'],'required'],[['study_program_id','new_student_curriculum_year_id','created_by','updated_by'],'integer'],[self::booleanAttributes(),'boolean'],['academic_period','string','max'=>50],['notes','string'],[['academic_period','study_program_id'],'unique','targetAttribute'=>['academic_period','study_program_id'],'message'=>'Pengaturan prodi pada periode tersebut sudah tersedia.'],['study_program_id','exist','targetClass'=>StudyProgram::class,'targetAttribute'=>['study_program_id'=>'id']],['new_student_curriculum_year_id','exist','skipOnEmpty'=>true,'targetClass'=>CurriculumYear::class,'targetAttribute'=>['new_student_curriculum_year_id'=>'id']],['created_by','exist','skipOnEmpty'=>true,'targetClass'=>User::class,'targetAttribute'=>['created_by'=>'id']],['updated_by','exist','skipOnEmpty'=>true,'targetClass'=>User::class,'targetAttribute'=>['updated_by'=>'id']]];}
    public static function booleanAttributes(){return ['krs_enabled','krs_validation_enabled','khs_enabled','grading_enabled','questionnaire_enabled','lecturer_meeting_generation_enabled'];}
    public static function booleanLabels(){return ['krs_enabled'=>'KRS','krs_validation_enabled'=>'Validasi KRS','khs_enabled'=>'KHS','grading_enabled'=>'Pengisian Nilai','questionnaire_enabled'=>'Pengisian Kuesioner','lecturer_meeting_generation_enabled'=>'Dosen Bisa Generate Tatap Muka'];}
    public function getStudyProgram(){return $this->hasOne(StudyProgram::class,['id'=>'study_program_id']);}public function getCurriculumYear(){return $this->hasOne(CurriculumYear::class,['id'=>'new_student_curriculum_year_id']);}
    public function attributeLabels(){return ['academic_period'=>'Periode','study_program_id'=>'Program Studi','new_student_curriculum_year_id'=>'Kurikulum Mahasiswa Baru','notes'=>'Keterangan']+self::booleanLabels();}
}
