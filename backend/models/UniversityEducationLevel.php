<?php
namespace backend\models;
use yii\behaviors\BlameableBehavior; use yii\behaviors\TimestampBehavior; use yii\db\ActiveRecord; use yii\db\Expression;
class UniversityEducationLevel extends ActiveRecord
{
    public static function tableName() { return 'university_education_levels'; }
    public function behaviors() { return [['class' => TimestampBehavior::class, 'value' => new Expression('NOW()')], BlameableBehavior::class]; }
    public function rules() { return [[['education_level_id', 'study_period_semesters', 'max_leave_semesters', 'max_study_semesters'], 'required'], [['education_level_id', 'study_period_semesters', 'max_leave_semesters', 'max_study_semesters'], 'integer'], [['study_period_semesters', 'max_leave_semesters', 'max_study_semesters'], 'integer', 'min' => 1], [['education_level_id'], 'unique'], [['education_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationLevel::class, 'targetAttribute' => ['education_level_id' => 'id']]]; }
    public function attributeLabels() { return ['education_level_id' => 'Jenjang', 'study_period_semesters' => 'Masa Studi (Smt)', 'max_leave_semesters' => 'Max. Cuti (Smt)', 'max_study_semesters' => 'Max. Studi (Smt)']; }
    public function getEducationLevel() { return $this->hasOne(EducationLevel::class, ['id' => 'education_level_id']); }
}
