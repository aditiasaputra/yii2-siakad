<?php

use yii\db\Migration;

class m260808_000001_create_study_programs_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%study_programs}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique()->comment('Kode Program Studi'),
            'name' => $this->string(255)->notNull()->comment('Nama Program Studi'),
            'faculty_id' => $this->integer()->null()->comment('Fakultas'),
            'program_type' => $this->string(20)->notNull()->comment('Jenis Program'),
            'capacity' => $this->integer()->notNull()->defaultValue(0)->comment('Kuota'),
            'grade' => $this->string(10)->null()->comment('Akreditasi/Grade'),
            'nim_prefix' => $this->string(20)->null()->comment('Prefix NIM'),
            'nim_sequence_length' => $this->smallInteger()->notNull()->defaultValue(3)->comment('Jumlah Urut NIM'),
            'allow_choice_1' => $this->boolean()->notNull()->defaultValue(true),
            'allow_choice_2' => $this->boolean()->notNull()->defaultValue(true),
            'allow_choice_3' => $this->boolean()->notNull()->defaultValue(true),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%idx-study-programs-faculty_id}}', '{{%study_programs}}', 'faculty_id');
        $this->createIndex('{{%idx-study-programs-is_active}}', '{{%study_programs}}', 'is_active');
        $this->addForeignKey('{{%fk-study-programs-faculty_id}}', '{{%study_programs}}', 'faculty_id', '{{%faculties}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-study-programs-created_by}}', '{{%study_programs}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-study-programs-updated_by}}', '{{%study_programs}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-study-programs-updated_by}}', '{{%study_programs}}');
        $this->dropForeignKey('{{%fk-study-programs-created_by}}', '{{%study_programs}}');
        $this->dropForeignKey('{{%fk-study-programs-faculty_id}}', '{{%study_programs}}');
        $this->dropIndex('{{%idx-study-programs-is_active}}', '{{%study_programs}}');
        $this->dropIndex('{{%idx-study-programs-faculty_id}}', '{{%study_programs}}');
        $this->dropTable('{{%study_programs}}');
    }
}
