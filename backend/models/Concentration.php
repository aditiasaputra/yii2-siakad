<?php
namespace backend\models;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Concentration extends ActiveRecord
{
    public static function tableName() { return 'concentrations'; }
    public function behaviors() { return [['class' => TimestampBehavior::class, 'value' => new Expression('NOW()')], BlameableBehavior::class]; }
    public function rules() { return [[['study_program_id', 'code', 'name'], 'required'], [['study_program_id', 'created_by', 'updated_by'], 'integer'], [['code'], 'string', 'max' => 20], [['name', 'name_en'], 'string', 'max' => 255], [['study_program_id', 'code'], 'unique', 'targetAttribute' => ['study_program_id', 'code']], [['study_program_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudyProgram::class, 'targetAttribute' => ['study_program_id' => 'id']]]; }
    public function attributeLabels() { return ['study_program_id' => 'Program Studi', 'code' => 'Kode', 'name' => 'Nama Konsentrasi', 'name_en' => 'Nama Konsentrasi (EN)']; }
    public function getStudyProgram() { return $this->hasOne(StudyProgram::class, ['id' => 'study_program_id']); }
}
