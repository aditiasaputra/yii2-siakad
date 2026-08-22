<?php
namespace backend\models;
use common\models\{Student,User};use yii\behaviors\{BlameableBehavior,TimestampBehavior};use yii\db\{ActiveRecord,Expression};
class KrsRegistration extends ActiveRecord
{
    const STATUS_DRAFT='draft',STATUS_SUBMITTED='submitted',STATUS_VALIDATED='validated';
    public static function tableName(){return 'krs_registrations';}public function behaviors(){return [['class'=>TimestampBehavior::class,'value'=>new Expression('NOW()')],BlameableBehavior::class];}
    public function rules(){return [[['student_id','academic_period','study_program_id','semester','maximum_credits','status'],'required'],[['student_id','study_program_id','semester','maximum_credits','validated_by','created_by','updated_by'],'integer'],[['semester'],'integer','min'=>1,'max'=>20],['maximum_credits','integer','min'=>1,'max'=>30],['academic_period','string','max'=>50],['status','in','range'=>array_keys(self::statusOptions())],['notes','string'],[['student_id','academic_period'],'unique','targetAttribute'=>['student_id','academic_period'],'message'=>'KRS mahasiswa pada periode tersebut sudah tersedia.'],['student_id','exist','targetClass'=>Student::class,'targetAttribute'=>['student_id'=>'id']],['study_program_id','exist','targetClass'=>StudyProgram::class,'targetAttribute'=>['study_program_id'=>'id']]];}
    public static function statusOptions(){return [self::STATUS_DRAFT=>'Draft',self::STATUS_SUBMITTED=>'Diajukan',self::STATUS_VALIDATED=>'Tervalidasi'];}
    public function getStudent(){return $this->hasOne(Student::class,['id'=>'student_id']);}public function getStudyProgram(){return $this->hasOne(StudyProgram::class,['id'=>'study_program_id']);}public function getItems(){return $this->hasMany(KrsRegistrationItem::class,['krs_registration_id'=>'id']);}public function getLectureClasses(){return $this->hasMany(LectureClass::class,['id'=>'lecture_class_id'])->via('items');}
    public function getTotalCredits(){return array_sum(array_map(static fn($c)=>(int)$c->curriculum->subject->credits,$this->lectureClasses));}
    public function attributeLabels(){return ['student_id'=>'Mahasiswa','academic_period'=>'Periode Akademik','study_program_id'=>'Program Studi','semester'=>'Semester','maximum_credits'=>'Batas SKS','status'=>'Status KRS','notes'=>'Keterangan'];}
}
