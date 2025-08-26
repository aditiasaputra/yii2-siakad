<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "faculties".
 *
 * @property int $id
 * @property string $unit_code Kode Fakultas
 * @property string $unit_name Nama Fakultas
 * @property string|null $unit_name_en Nama Fakultas EN
 * @property string|null $abbreviation Nama Singkat
 * @property string|null $address Alamat
 * @property string|null $work_unit Fakultas/Satuan Kerja
 * @property string|null $phone Telepon
 * @property string|null $dean Ketua
 * @property string|null $vice_dean_1 Wakil Ketua
 * @property string|null $vice_dean_2 Wakil Ketua 2
 * @property string|null $vice_dean_3 Wakil Ketua 3
 * @property bool $is_active Status Aktif
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property University[] $university
 */
class Faculty extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculties';
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
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
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
            [['is_active'], 'boolean'],
            [['created_by', 'updated_by', 'deleted_at'], 'integer'],
            [['unit_code'], 'string', 'max' => 20],
            [['unit_name', 'unit_name_en', 'work_unit'], 'string', 'max' => 255],
            [['abbreviation'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['dean', 'vice_dean_1', 'vice_dean_2', 'vice_dean_3'], 'string', 'max' => 255],
            [['unit_code'], 'unique'],
            [['phone'], 'match', 'pattern' => '/^[+]?[\d\s\-\(\)]+$/'],
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
            'unit_code' => 'Kode Fakultas',
            'unit_name' => 'Nama Fakultas',
            'unit_name_en' => 'Nama Fakultas (English)',
            'abbreviation' => 'Nama Singkat',
            'address' => 'Alamat',
            'work_unit' => 'Fakultas/Satuan Kerja',
            'phone' => 'Telepon',
            'dean' => 'Ketua/Rektor',
            'vice_dean_1' => 'Wakil Ketua 1',
            'vice_dean_2' => 'Wakil Ketua 2',
            'vice_dean_3' => 'Wakil Ketua 3',
            'is_active' => 'Status Aktif',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diubah Oleh',
            'deleted_at' => 'Tanggal Dihapus',
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
     * Gets query for [[Univesity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUniversity()
    {
        return $this->hasMany(University::class, ['university_id' => 'id']);
    }

    /**
     * Get status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->is_active ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * Get status badge
     */
    public function getUnitCode()
    {
        return '<span class="badge badge-secondary">' . $this->unit_code . '</span>';
    }

    /**
     * Get status badge
     */
    public function getStatusBadge()
    {
        $class = $this->is_active ? 'badge-success' : 'badge-secondary';
        return '<span class="badge ' . $class . '">' . $this->getStatusLabel() . '</span>';
    }

    /**
     * Search active faculties
     */
    public static function getActiveFaculties()
    {
        return static::find()->where(['is_active' => true])->all();
    }

    /**
     * Get faculty dropdown data
     *
     * @return array
     */
    public static function getDropdownData()
    {
        return self::findActive()
            ->select(['id', 'unit_name'])
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
            
            return true;
        }
        return false;
    }

    /**
     * Generate unit code from faculty name
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
     * Get faculty display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->abbreviation ? "{$this->unit_name} ({$this->abbreviation})" : $this->unit_name;
    }
}