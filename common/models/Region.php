<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "regions".
 *
 * @property string $kode
 * @property string $name
 */
class Region extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%regions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'name', 'level'], 'required'],
            [['kode'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            ['level', 'in', 'range' => ['province', 'regency', 'district', 'village']],
            ['parent_kode', 'string', 'max' => 20],
            ['parent_kode', 'required', 'when' => static fn($model) => $model->level !== 'province'],
            ['parent_kode', 'exist', 'skipOnEmpty' => true, 'targetClass' => self::class, 'targetAttribute' => ['parent_kode' => 'kode']],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode Wilayah',
            'name' => 'Nama Wilayah',
            'level' => 'Tingkat Wilayah',
            'parent_kode' => 'Wilayah Induk',
        ];
    }

    public function getParent()
    {
        return $this->hasOne(self::class, ['kode' => 'parent_kode']);
    }

    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_kode' => 'kode']);
    }

    public static function levelLabels(): array
    {
        return [
            'province' => 'Provinsi',
            'regency' => 'Kota/Kabupaten',
            'district' => 'Kecamatan',
            'village' => 'Desa/Kelurahan',
        ];
    }

    public static function generateNextCode(string $level, ?string $parentKode = null): string
    {
        if (!in_array($level, ['province', 'regency', 'district'], true)) {
            throw new \InvalidArgumentException('Tingkat wilayah tidak mendukung kode otomatis.');
        }

        if ($level !== 'province') {
            $expectedParentLevel = $level === 'regency' ? 'province' : 'regency';
            $parent = self::findOne(['kode' => $parentKode, 'level' => $expectedParentLevel]);
            if ($parent === null) {
                throw new \InvalidArgumentException('Wilayah induk tidak valid.');
            }
        } else {
            $parentKode = null;
        }

        $lastSegment = new Expression("CAST(SUBSTRING_INDEX([[kode]], '.', -1) AS UNSIGNED)");
        $lastNumber = (int) self::find()
            ->where(['level' => $level, 'parent_kode' => $parentKode])
            ->max($lastSegment);
        $nextNumber = $lastNumber + 1;

        if ($nextNumber > 99) {
            throw new \OverflowException('Kode wilayah pada tingkat ini sudah mencapai batas 99.');
        }

        $segment = str_pad((string) $nextNumber, 2, '0', STR_PAD_LEFT);
        return $parentKode === null ? $segment : $parentKode . '.' . $segment;
    }

    /**
     * Get a list of regions by level, optionally limited by parent kode.
     *
     * @param string $level
     * @param string|null $parentKode
     * @return array
     */
    public static function getList(string $level, ?string $parentKode = null): array
    {
        return self::find()
            ->select(['kode AS id', 'name AS text'])
            ->where(['level' => $level])
            ->andFilterWhere(['parent_kode' => $parentKode])
            ->orderBy('name')
            ->asArray()
            ->all();
    }
}
