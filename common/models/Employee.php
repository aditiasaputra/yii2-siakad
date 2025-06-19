<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $employee_number
 * @property int $user_id
 * @property int|null $tax_number
 * @property int|null $bank_id
 * @property string|null $branch_name
 * @property string|null $account_number
 * @property string|null $account_name
 * @property string|null $national_social_security_number
 * @property string|null $national_health_insurance_number
 * @property string|null $social_security_number
 * @property string|null $health_insurance_number
 * @property string|null $note
 * @property User $user
 * @property Lecture $lecture
 * @property Bank $bank
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_number', 'user_id'], 'required'],
            [['user_id', 'tax_number', 'bank_id'], 'integer'],
            [['note'], 'string'],
            [['employee_number', 'branch_name', 'account_number', 'account_name'], 'string', 'max' => 255],
            [['national_social_security_number', 'national_health_insurance_number', 'social_security_number', 'health_insurance_number'], 'string', 'max' => 16],

            // Relasi ke User
            [['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            // Relasi ke Bank (opsional)
            // [['bank_id'], 'exist', 'skipOnError' => true,
            //     'targetClass' => Bank::class, 'targetAttribute' => ['bank_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_number' => 'NIP / Nomor Pegawai',
            'user_id' => 'User',
            'tax_number' => 'NPWP',
            'bank_id' => 'Bank',
            'branch_name' => 'Cabang Bank',
            'account_number' => 'No Rekening',
            'account_name' => 'Nama Pemilik Rekening',
            'national_social_security_number' => 'No BPJS Ketenagakerjaan',
            'national_health_insurance_number' => 'No BPJS Kesehatan',
            'social_security_number' => 'Asuransi Pegawai (Non Nasional)',
            'health_insurance_number' => 'Asuransi Kesehatan (Non Nasional)',
            'note' => 'Catatan',
        ];
    }

    /**
     * Gets a related User model
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets a related Lecture model
     * @return \yii\db\ActiveQuery
     */
    public function getLecture()
    {
        return $this->hasOne(Lecture::class, ['employee_id' => 'id']);
    }

    /**
     * Gets a related Bank model
     * @return \yii\db\ActiveQuery
     */
    // public function getBank()
    // {
    //     return $this->hasOne(Bank::class, ['id' => 'bank_id']);
    // }
}
