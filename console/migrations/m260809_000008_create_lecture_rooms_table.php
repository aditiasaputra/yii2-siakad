<?php

use yii\db\Migration;

class m260809_000008_create_lecture_rooms_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%lecture_rooms}}', [
            'id' => $this->primaryKey(),
            'study_program_id' => $this->integer()->notNull()->comment('Unit/Program Studi'),
            'code' => $this->string(20)->notNull()->unique()->comment('Kode Ruang Kuliah'),
            'name' => $this->string(255)->notNull()->comment('Nama Ruang'),
            'location' => $this->string(255)->notNull()->comment('Lokasi Ruang'),
            'capacity' => $this->integer()->notNull()->comment('Kapasitas Ruang'),
            'is_active' => $this->boolean()->notNull()->defaultValue(true)->comment('Status Aktif'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-lecture-rooms-study-program}}', '{{%lecture_rooms}}', 'study_program_id', '{{%study_programs}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('{{%fk-lecture-rooms-created-by}}', '{{%lecture_rooms}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-lecture-rooms-updated-by}}', '{{%lecture_rooms}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-lecture-rooms-updated-by}}', '{{%lecture_rooms}}');
        $this->dropForeignKey('{{%fk-lecture-rooms-created-by}}', '{{%lecture_rooms}}');
        $this->dropForeignKey('{{%fk-lecture-rooms-study-program}}', '{{%lecture_rooms}}');
        $this->dropTable('{{%lecture_rooms}}');
    }
}
