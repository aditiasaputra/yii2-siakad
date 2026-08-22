<?php
namespace backend\models;
use yii\db\ActiveRecord;
class LectureClassSchedule extends ActiveRecord
{
    public static function tableName(){return 'lecture_class_schedules';}
    public function rules(){return [[['lecture_class_id','weekday','start_time_slot_id','end_time_slot_id'],'required'],[['lecture_class_id','weekday','start_time_slot_id','end_time_slot_id','lecture_room_id'],'integer'],['weekday','integer','min'=>1,'max'=>7],['end_time_slot_id','validateTimeOrder']];}
    public function validateTimeOrder($attribute){if($this->hasErrors())return;$start=TimeSlot::findOne($this->start_time_slot_id);$end=TimeSlot::findOne($this->end_time_slot_id);if(!$start||!$end||$end->time<=$start->time)$this->addError($attribute,'Jam selesai harus setelah jam mulai.');}
    public static function dayOptions(){return [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];}
    public function getStartTimeSlot(){return $this->hasOne(TimeSlot::class,['id'=>'start_time_slot_id']);} public function getEndTimeSlot(){return $this->hasOne(TimeSlot::class,['id'=>'end_time_slot_id']);} public function getLectureRoom(){return $this->hasOne(LectureRoom::class,['id'=>'lecture_room_id']);}
}
