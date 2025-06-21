<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wilayah".
 *
 * @property string $kode
 * @property string $nama
 */
class Region extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wilayah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama'], 'required'],
            [['kode'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 255],
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
            'nama' => 'Nama Wilayah',
        ];
    }

    public static function getList($parentCode = null)
    {
        if ($parentCode === null) {
            // Provinsi: kode panjangnya 2 karakter
            return self::find()
                ->where(['LENGTH(kode)' => 2])
                ->orderBy('nama')
                ->asArray()
                ->all();
        }

        $length = strlen($parentCode);
        $nextLength = match($length) {
            2 => 5,   // dari provinsi ke kabupaten
            5 => 8,   // dari kabupaten ke kecamatan
            8 => 13,  // dari kecamatan ke desa
            default => null,
        };

        if ($nextLength === null) {
            return [];
        }

        return self::find()
            ->where(['like', 'kode', $parentCode . '%', false])
            ->andWhere(['LENGTH(kode)' => $nextLength])
            ->orderBy('nama')
            ->asArray()
            ->all();
    }
}