<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "religion".
 *
 * @property int $id
 * @property string $status
 * @property string $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class Religion extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'religion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'name'], 'required'],
            [['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['status'], 'in', 'range' => ['active', 'deleted']],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'name' => 'Nama Agama',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diperbarui Pada',
            'deleted_at' => 'Dihapus Pada',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diperbarui Oleh',
            'deleted_by' => 'Dihapus Oleh',
        ];
    }

    /**
     * Add behaviors to auto-fill timestamps and user ids
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
            \yii\behaviors\BlameableBehavior::class,
        ];
    }
}