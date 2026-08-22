<?php
namespace backend\models;
use common\models\{Student,User};use yii\behaviors\{BlameableBehavior,TimestampBehavior};use yii\db\{ActiveRecord,Expression};
class KrsBlock extends ActiveRecord
{
    public static function tableName(){return 'krs_blocks';}
    public function behaviors(){return [['class'=>TimestampBehavior::class,'value'=>new Expression('NOW()')],BlameableBehavior::class];}
    public function rules(){return [[['student_id','academic_period','study_program_id','entry_year','current_semester'],'required'],[['student_id','study_program_id','entry_year','current_semester','created_by','updated_by'],'integer'],[['academic_block','finance_block','library_block','student_affairs_block'],'boolean'],['entry_year','integer','min'=>1900,'max'=>2200],['current_semester','integer','min'=>1,'max'=>20],['academic_period','string','max'=>50],['notes','string'],[['student_id','academic_period'],'unique','targetAttribute'=>['student_id','academic_period'],'message'=>'Mahasiswa tersebut sudah memiliki data cekal pada periode ini.'],['student_id','exist','targetClass'=>Student::class,'targetAttribute'=>['student_id'=>'id']],['study_program_id','exist','targetClass'=>StudyProgram::class,'targetAttribute'=>['study_program_id'=>'id']],['created_by','exist','skipOnEmpty'=>true,'targetClass'=>User::class,'targetAttribute'=>['created_by'=>'id']],['updated_by','exist','skipOnEmpty'=>true,'targetClass'=>User::class,'targetAttribute'=>['updated_by'=>'id']]];}
    public function getStudent(){return $this->hasOne(Student::class,['id'=>'student_id']);}public function getStudyProgram(){return $this->hasOne(StudyProgram::class,['id'=>'study_program_id']);}
    public function getHasBlock(){return $this->academic_block||$this->finance_block||$this->library_block||$this->student_affairs_block;}
    public static function blockAttributes(){return ['academic_block'=>'Akademik','finance_block'=>'Keuangan','library_block'=>'Perpustakaan','student_affairs_block'=>'Kemahasiswaan'];}
    public function attributeLabels(){return ['student_id'=>'Mahasiswa','academic_period'=>'Periode','study_program_id'=>'Program Studi','entry_year'=>'Tahun Masuk','current_semester'=>'Semester','academic_block'=>'Cekal Akademik','finance_block'=>'Cekal Keuangan','library_block'=>'Cekal Perpustakaan','student_affairs_block'=>'Cekal Kemahasiswaan','notes'=>'Keterangan'];}
}
