<?php
namespace backend\models;
use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
class AcademicCalendar extends ActiveRecord
{
    public static function tableName() { return 'academic_calendars'; }
    public function behaviors() { return [['class' => TimestampBehavior::class, 'value' => new Expression('NOW()')], BlameableBehavior::class]; }
    public function rules() { return [[['period', 'academic_activity_id', 'start_date', 'end_date', 'description'], 'required'], [['academic_activity_id', 'created_by', 'updated_by'], 'integer'], [['is_academic_holiday', 'is_national_holiday'], 'boolean'], [['period'], 'string', 'max' => 50], [['description'], 'string'], [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'], ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>=', 'type' => 'date', 'message' => 'Tanggal selesai harus sama atau setelah tanggal mulai.'], [['academic_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicActivity::class, 'targetAttribute' => ['academic_activity_id' => 'id']], [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']], [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']]]; }
    public function getAcademicActivity() { return $this->hasOne(AcademicActivity::class, ['id' => 'academic_activity_id']); }
    public function getHolidayLabel() { $labels = []; if ($this->is_academic_holiday) $labels[] = 'Libur Akademik'; if ($this->is_national_holiday) $labels[] = 'Libur Nasional'; return $labels ? implode(', ', $labels) : '-'; }
    public function attributeLabels() { return ['period' => 'Periode Akademik', 'academic_activity_id' => 'Kegiatan', 'start_date' => 'Tgl Mulai', 'end_date' => 'Tgl Selesai', 'description' => 'Keterangan', 'is_academic_holiday' => 'Libur Akademik', 'is_national_holiday' => 'Libur Nasional']; }
}
