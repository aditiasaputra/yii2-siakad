<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "lecture".
 *
 * @property int $id
 * @property int $user_id
 * @property string $employee_id
 * @property string $lecture_nationality_number
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 */
class Lecture extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lecture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lecture_nationality_number', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'created_by', 'updated_by'], 'integer'],

            ['employee_id', 'trim'],
            ['employee_id', 'unique'],
            ['employee_id', 'string', 'min' => 2, 'max' => 10],

            ['lecture_nationality_number', 'trim'],
            ['lecture_nationality_number', 'unique'],
            ['lecture_nationality_number', 'string', 'min' => 2, 'max' => 10],

            [['created_by', 'updated_by', 'deleted_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'lecture_nationality_number' => 'Nidn',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
