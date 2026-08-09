<?php
namespace backend\models;
use common\models\User; use yii\behaviors\BlameableBehavior; use yii\behaviors\TimestampBehavior; use yii\db\ActiveRecord; use yii\db\Expression;
class Transportation extends ActiveRecord
{
    public static function tableName() { return 'transportations'; }
    public function behaviors() { return [['class' => TimestampBehavior::class, 'value' => new Expression('NOW()')], BlameableBehavior::class]; }
    public function rules() { return [[['code','name'],'required'], ['code','match','pattern'=>'/^\d+$/','message'=>'Kode harus berupa angka.'], ['code','string','max'=>20], ['name','string','max'=>255], ['code','unique'], [['created_by','updated_by'],'integer'], ['created_by','exist','skipOnError'=>true,'targetClass'=>User::class,'targetAttribute'=>['created_by'=>'id']], ['updated_by','exist','skipOnError'=>true,'targetClass'=>User::class,'targetAttribute'=>['updated_by'=>'id']]]; }
    public function attributeLabels() { return ['code'=>'Kode','name'=>'Nama Transportasi']; }
}
