<?php
namespace backend\models;
use common\models\Lecture; use yii\db\ActiveRecord;
class LectureClassMeeting extends ActiveRecord
{
    public static function tableName(){return 'lecture_class_meetings';}
    public function rules(){return [[['lecture_class_id','meeting_number','schedule_date','start_time_slot_id','end_time_slot_id','status','meeting_type'],'required'],[['lecture_class_id','meeting_number','start_time_slot_id','end_time_slot_id','lecture_room_id','lecturer_id'],'integer'],['meeting_number','integer','min'=>1],['schedule_date','date','format'=>'php:Y-m-d'],['status','in','range'=>array_keys(self::statusOptions())],['meeting_type','in','range'=>array_keys(self::typeOptions())],['credits','number','min'=>0],['location','string','max'=>255],[['planned_material','realized_material'],'string'],['attachment','string','max'=>255],[['lecture_class_id','meeting_number'],'unique','targetAttribute'=>['lecture_class_id','meeting_number']],['end_time_slot_id','validateTimeOrder']];}
    public function validateTimeOrder($a){if($this->hasErrors())return;$s=TimeSlot::findOne($this->start_time_slot_id);$e=TimeSlot::findOne($this->end_time_slot_id);if(!$s||!$e||$e->time<=$s->time)$this->addError($a,'Waktu selesai harus setelah waktu mulai.');}
    public static function statusOptions(){return ['scheduled'=>'Terjadwal','completed'=>'Selesai','cancelled'=>'Dibatalkan'];} public static function typeOptions(){return ['lecture'=>'Kuliah','practicum'=>'Praktikum','exam'=>'Ujian','other'=>'Lainnya'];}
    public function getStartTimeSlot(){return $this->hasOne(TimeSlot::class,['id'=>'start_time_slot_id']);}public function getEndTimeSlot(){return $this->hasOne(TimeSlot::class,['id'=>'end_time_slot_id']);}public function getLectureRoom(){return $this->hasOne(LectureRoom::class,['id'=>'lecture_room_id']);}public function getLecturer(){return $this->hasOne(Lecture::class,['id'=>'lecturer_id']);}
    public function attributeLabels(){return ['meeting_number'=>'Pert. Ke-','schedule_date'=>'Tanggal Jadwal','start_time_slot_id'=>'Waktu Mulai','end_time_slot_id'=>'Waktu Selesai','lecture_room_id'=>'Ruang Kuliah','lecturer_id'=>'Pengajar','status'=>'Status','credits'=>'SKS','location'=>'Lokasi','meeting_type'=>'Jenis Pertemuan','planned_material'=>'Rencana Materi','realized_material'=>'Realisasi Materi','attachment'=>'Lampiran'];}
}
