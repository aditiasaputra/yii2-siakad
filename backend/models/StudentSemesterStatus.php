<?php
namespace backend\models;
use common\models\{Student,User};use yii\behaviors\{BlameableBehavior,TimestampBehavior};use yii\db\{ActiveRecord,Expression};
class StudentSemesterStatus extends ActiveRecord
{
    const STATUS_ACTIVE='active',STATUS_LEAVE='leave',STATUS_INACTIVE='inactive';
    public static function tableName(){return 'student_semester_statuses';}
    public function behaviors(){return [['class'=>TimestampBehavior::class,'value'=>new Expression('NOW()')],BlameableBehavior::class];}
    public function rules(){return [[['student_id','academic_period','study_program_id','semester','status'],'required'],[['student_id','study_program_id','semester','created_by','updated_by'],'integer'],['semester','integer','min'=>1,'max'=>20],['academic_period','string','max'=>50],['status','in','range'=>array_keys(self::statusOptions())],['notes','string'],[['student_id','academic_period'],'unique','targetAttribute'=>['student_id','academic_period'],'message'=>'Status semester mahasiswa pada periode tersebut sudah tersedia.'],['student_id','exist','targetClass'=>Student::class,'targetAttribute'=>['student_id'=>'id']],['study_program_id','exist','targetClass'=>StudyProgram::class,'targetAttribute'=>['study_program_id'=>'id']],['created_by','exist','skipOnEmpty'=>true,'targetClass'=>User::class,'targetAttribute'=>['created_by'=>'id']],['updated_by','exist','skipOnEmpty'=>true,'targetClass'=>User::class,'targetAttribute'=>['updated_by'=>'id']]];}
    public static function statusOptions(){return [self::STATUS_ACTIVE=>'Aktif',self::STATUS_LEAVE=>'Cuti',self::STATUS_INACTIVE=>'Non Aktif'];}
    public static function statusDescriptions(){return [self::STATUS_ACTIVE=>'Mahasiswa telah melakukan KRS dan telah divalidasi oleh dosen wali.',self::STATUS_LEAVE=>'Mahasiswa belum melakukan KRS ataupun belum divalidasi oleh dosen wali.',self::STATUS_INACTIVE=>'Mahasiswa yang akan melakukan KRS pada semester depan.'];}
    public function getStudent(){return $this->hasOne(Student::class,['id'=>'student_id']);}public function getStudyProgram(){return $this->hasOne(StudyProgram::class,['id'=>'study_program_id']);}
    public function attributeLabels(){return ['student_id'=>'Mahasiswa','academic_period'=>'Periode','study_program_id'=>'Program Studi','semester'=>'Semester','status'=>'Status Semester','notes'=>'Keterangan'];}
}
