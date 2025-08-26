<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%universities}}`.
 */
class m250815_061422_create_universities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%universities}}', [
            'id' => $this->primaryKey(),
            'unit_code' => $this->string(20)->notNull()->unique()->comment('Kode Unit'),
            'unit_name' => $this->string(255)->notNull()->comment('Nama Unit'),
            'unit_name_en' => $this->string(255)->null()->comment('Nama Unit EN'),
            'abbreviation' => $this->string(50)->null()->comment('Nama Singkat'),
            'address' => $this->text()->null()->comment('Alamat'),
            'work_unit' => $this->string(255)->null()->comment('Unit/Satuan Kerja'),
            'phone' => $this->string(20)->null()->comment('Telepon'),
            'accreditation' => $this->string(10)->null()->comment('Akreditasi'),
            'accreditation_sk_number' => $this->string(100)->null()->comment('No. SK Akreditasi'),
            'establishment_permit_number' => $this->string(100)->null()->comment('No. SP Pendirian'),
            'rector' => $this->string(255)->null()->comment('Ketua'),
            'vice_rector_1' => $this->string(255)->null()->comment('Wakil Ketua'),
            'vice_rector_2' => $this->string(255)->null()->comment('Wakil Ketua 2'),
            'vice_rector_3' => $this->string(255)->null()->comment('Wakil Ketua 3'),
            'website' => $this->string(255)->null()->comment('Website'),
            'email' => $this->string(100)->null()->comment('Email'),
            'logo' => $this->string(255)->null()->comment('Logo'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        // Create indexes
        $this->createIndex(
            '{{%idx-universities-unit_code}}',
            '{{%universities}}',
            'unit_code'
        );

        // Add foreign key for created_by and updated_by
        $this->addForeignKey(
            '{{%fk-universities-created_by}}',
            '{{%universities}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            '{{%fk-universities-updated_by}}',
            '{{%universities}}',
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
            '{{%fk-universities-created_by}}',
            '{{%universities}}'
        );

        $this->dropForeignKey(
            '{{%fk-universities-updated_by}}',
            '{{%universities}}'
        );

        // Drop indexes
        $this->dropIndex(
            '{{%idx-universities-unit_code}}',
            '{{%universities}}'
        );

        $this->dropTable('{{%universities}}');
    }
}
