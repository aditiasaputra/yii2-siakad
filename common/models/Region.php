<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wilayah".
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
        return '{{%region}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'name'], 'required'],
            [['kode'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Get a list of child regions by parent kode and level
     *
     * @param string|null $parentKode
     * @param string $level
     * @return array
     */
    public static function getList(?string $parentKode = null, string $level): array
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