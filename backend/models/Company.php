<?php
namespace backend\models;
use yii\behaviors\TimestampBehavior; use yii\db\ActiveRecord; use yii\db\Expression;
class Company extends ActiveRecord { public static function tableName() { return 'companies'; } public function behaviors() { return [['class' => TimestampBehavior::class, 'value' => new Expression('NOW()')]]; } public function rules() { return [[['number', 'name', 'address', 'phone'], 'required'], ['number', 'match', 'pattern' => '/^\d+$/', 'message' => 'No harus berupa angka.'], ['number', 'string', 'max' => 20], ['name', 'string', 'max' => 255], ['address', 'string'], ['phone', 'string', 'max' => 30], ['number', 'unique']]; } public function attributeLabels() { return ['number' => 'No', 'name' => 'Nama Perusahaan', 'address' => 'Alamat', 'phone' => 'No. Telp']; } }
