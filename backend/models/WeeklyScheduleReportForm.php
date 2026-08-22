<?php
namespace backend\models;
use yii\base\Model;
class WeeklyScheduleReportForm extends Model
{
    public $academic_period; public $study_program_id; public $semester=1; public $student_id; public $format='html'; public $use_letterhead=1;
    public function rules(){return [[['academic_period','study_program_id','semester','format'],'required'],[['study_program_id','semester','student_id'],'integer'],['semester','integer','min'=>1,'max'=>14],['format','in','range'=>['html','pdf']],[['use_letterhead'],'boolean']];}
    public function attributeLabels(){return ['academic_period'=>'Periode Akademik','study_program_id'=>'Program Studi','semester'=>'Semester','student_id'=>'Mahasiswa','format'=>'Format','use_letterhead'=>'KOP'];}
}
