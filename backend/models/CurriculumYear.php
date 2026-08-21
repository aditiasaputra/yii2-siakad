<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class CurriculumYear extends ActiveRecord
{
    public static function tableName()
    {
        return 'curriculum_years';
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
            [['year', 'description'], 'required'],
            ['year', 'integer', 'min' => 1900, 'max' => 2100],
            ['year', 'unique', 'message' => 'Tahun kurikulum sudah digunakan.'],
            ['description', 'filter', 'filter' => 'trim'],
            ['description', 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'integer'],
            ['created_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['updated_by', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['year' => 'Tahun', 'description' => 'Keterangan'];
    }
}
