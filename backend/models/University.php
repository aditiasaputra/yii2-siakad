<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "universities".
 *
 * @property int $id
 * @property string $unit_code Kode Unit
 * @property string $unit_name Nama Unit
 * @property string|null $unit_name_en Nama Unit EN
 * @property string|null $abbreviation Nama Singkat
 * @property string|null $address Alamat
 * @property string|null $work_unit Unit/Satuan Kerja
 * @property string|null $phone Telepon
 * @property string|null $accreditation Akreditasi
 * @property string|null $accreditation_sk_number No. SK Akreditasi
 * @property string|null $establishment_permit_number No. SP Pendirian
 * @property string|null $rector Ketua
 * @property string|null $vice_rector_1 Wakil Ketua
 * @property string|null $vice_rector_2 Wakil Ketua 2
 * @property string|null $vice_rector_3 Wakil Ketua 3
 * @property string|null $website Website
 * @property string|null $email Email
 * @property string|null $logo Logo
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Faculty[] $faculties
 */
class University extends ActiveRecord
{
    // Accreditation constants
    const ACCREDITATION_A = 'A';
    const ACCREDITATION_B = 'B';
    const ACCREDITATION_C = 'C';
    const ACCREDITATION_UNGGUL = 'Unggul';
    const ACCREDITATION_BAIK_SEKALI = 'Baik Sekali';
    const ACCREDITATION_BAIK = 'Baik';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'universities';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_code', 'unit_name'], 'required'],
            [['address'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['unit_code'], 'string', 'max' => 20],
            [['unit_name', 'unit_name_en', 'work_unit', 'website', 'logo'], 'string', 'max' => 255],
            [['abbreviation'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['accreditation'], 'string', 'max' => 10],
            [['accreditation_sk_number', 'establishment_permit_number', 'email'], 'string', 'max' => 100],
            [['rector', 'vice_rector_1', 'vice_rector_2', 'vice_rector_3'], 'string', 'max' => 255],
            [['unit_code'], 'unique'],
            [['email'], 'email'],
            [['website'], 'url'],
            [['phone'], 'match', 'pattern' => '/^[+]?[\d\s\-\(\)]+$/'],
            [['accreditation'], 'in', 'range' => array_keys(self::getAccreditationOptions())],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_code' => 'Kode Unit',
            'unit_name' => 'Nama Unit',
            'unit_name_en' => 'Nama Unit (English)',
            'abbreviation' => 'Nama Singkat',
            'address' => 'Alamat',
            'work_unit' => 'Unit/Satuan Kerja',
            'phone' => 'Telepon',
            'accreditation' => 'Akreditasi',
            'accreditation_sk_number' => 'No. SK Akreditasi',
            'establishment_permit_number' => 'No. SP Pendirian',
            'rector' => 'Ketua/Rektor',
            'vice_rector_1' => 'Wakil Ketua 1',
            'vice_rector_2' => 'Wakil Ketua 2',
            'vice_rector_3' => 'Wakil Ketua 3',
            'website' => 'Website',
            'email' => 'Email',
            'logo' => 'Logo',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diubah Oleh',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[Faculties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaculties()
    {
        return $this->hasMany(Faculty::class, ['university_id' => 'id']);
    }

    /**
     * Get accreditation options
     *
     * @return array
     */
    public static function getAccreditationOptions()
    {
        return [
            self::ACCREDITATION_UNGGUL => 'Unggul',
            self::ACCREDITATION_BAIK_SEKALI => 'Baik Sekali',
            self::ACCREDITATION_BAIK => 'Baik',
            self::ACCREDITATION_A => 'A',
            self::ACCREDITATION_B => 'B',
            self::ACCREDITATION_C => 'C',
        ];
    }

    /**
     * Get accreditation label
     *
     * @return string
     */
    public function getAccreditationLabel()
    {
        $options = self::getAccreditationOptions();
        return isset($options[$this->accreditation]) ? $options[$this->accreditation] : '-';
    }

    /**
     * Get university dropdown data
     *
     * @return array
     */
    public static function getDropdownData()
    {
        return self::select(['id', 'unit_name'])
            ->orderBy('unit_name ASC')
            ->asArray()
            ->all();
    }

    /**
     * Before save event
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Auto generate unit code if empty
            if (empty($this->unit_code) && !empty($this->unit_name)) {
                $this->unit_code = $this->generateUnitCode();
            }
            
            // Clean up URL format
            if (!empty($this->website)) {
                if (strpos($this->website, 'http') !== 0) {
                    $this->website = 'https://' . $this->website;
                }
            }
            
            return true;
        }
        return false;
    }

    /**
     * Generate unit code from university name
     *
     * @return string
     */
    protected function generateUnitCode()
    {
        $words = explode(' ', $this->unit_name);
        $code = '';
        
        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $code .= strtoupper(substr($word, 0, 1));
            }
        }
        
        // Add number if code already exists
        $counter = 1;
        $baseCode = $code;
        while (self::find()->where(['unit_code' => $code])->andWhere(['!=', 'id', $this->id])->exists()) {
            $code = $baseCode . $counter;
            $counter++;
        }
        
        return $code;
    }

    /**
     * Get university display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->abbreviation ? "{$this->unit_name} ({$this->abbreviation})" : $this->unit_name;
    }
}
