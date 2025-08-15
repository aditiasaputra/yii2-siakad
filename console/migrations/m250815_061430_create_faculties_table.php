<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%faculties}}`.
 */
class m250815_061430_create_faculties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%faculties}}', [
            'id' => $this->primaryKey(),
            'unit_code' => $this->string(20)->notNull()->unique()->comment('Kode Unit'),
            'unit_name' => $this->string(255)->notNull()->comment('Nama Unit'),
            'unit_name_en' => $this->string(255)->null()->comment('Nama Unit EN'),
            'abbreviation' => $this->string(50)->null()->comment('Nama Singkat'),
            'address' => $this->text()->null()->comment('Alamat'),
            'work_unit' => $this->string(255)->null()->comment('Unit/Satuan Kerja'),
            'phone' => $this->string(20)->null()->comment('Telepon'),
            'dean' => $this->string(255)->null()->comment('Ketua'),
            'vice_dean_1' => $this->string(255)->null()->comment('Wakil Ketua'),
            'vice_dean_2' => $this->string(255)->null()->comment('Wakil Ketua 2'),
            'vice_dean_3' => $this->string(255)->null()->comment('Wakil Ketua 3'),
            'is_active' => $this->boolean()->defaultValue(true)->comment('Status Aktif'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        // Create indexes
        $this->createIndex(
            '{{%idx-faculties-unit_code}}',
            '{{%faculties}}',
            'unit_code'
        );

        $this->createIndex(
            '{{%idx-faculties-is_active}}',
            '{{%faculties}}',
            'is_active'
        );

        // Add foreign key for created_by and updated_by
        $this->addForeignKey(
            '{{%fk-faculties-created_by}}',
            '{{%faculties}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            '{{%fk-faculties-updated_by}}',
            '{{%faculties}}',
            'updated_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys
        $this->dropForeignKey(
            '{{%fk-faculties-created_by}}',
            '{{%faculties}}'
        );

        $this->dropForeignKey(
            '{{%fk-faculties-updated_by}}',
            '{{%faculties}}'
        );

        // Drop indexes
        $this->dropIndex(
            '{{%idx-faculties-unit_code}}',
            '{{%faculties}}'
        );

        $this->dropIndex(
            '{{%idx-faculties-is_active}}',
            '{{%faculties}}'
        );

        $this->dropTable('{{%faculties}}');
    }
}
