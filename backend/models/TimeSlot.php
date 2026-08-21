<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class TimeSlot extends ActiveRecord
{
    public static function tableName()
    {
        return 'time_slots';
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
            ['time', 'required'],
            ['time', 'filter', 'filter' => static fn($value) => $value ? substr($value, 0, 5) : $value],
            ['time', 'match', 'pattern' => '/^(?:[01]\d|2[0-3]):[0-5]\d$/', 'message' => 'Waktu harus menggunakan format HH:mm.'],
            ['time', 'unique', 'message' => 'Slot waktu sudah digunakan.'],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['time' => 'Waktu'];
    }

    public function getFormattedTime(): string
    {
        return substr($this->time, 0, 5);
    }

    public function getPeriod(): string
    {
        $hour = (int) substr($this->time, 0, 2);
        if ($hour < 12) {
            return 'morning';
        }
        return $hour < 18 ? 'afternoon' : 'evening';
    }
}
