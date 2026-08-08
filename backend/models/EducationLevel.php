<?php

namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class EducationLevel extends ActiveRecord
{
    public static function tableName()
    {
        return 'education_levels';
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
            [['level', 'name', 'sort_order'], 'required'],
            [['sort_order', 'created_by', 'updated_by'], 'integer'],
            [['sort_order'], 'integer', 'min' => 1],
            [['is_university'], 'boolean'],
            [['level'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['level'], 'unique'],
            [['sort_order'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ['level' => 'Jenjang', 'name' => 'Nama Tingkat Pendidikan', 'sort_order' => 'Urutan Tingkat Pendidikan', 'is_university' => 'Perguruan Tinggi'];
    }
}
