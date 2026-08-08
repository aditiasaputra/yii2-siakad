<?php

use yii\db\Migration;

class m260808_000007_create_lecture_systems_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%lecture_systems}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique()->comment('Kode Sistem Kuliah'),
            'name' => $this->string(255)->notNull()->comment('Nama Sistem Kuliah'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-lecture-systems-created-by}}', '{{%lecture_systems}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-lecture-systems-updated-by}}', '{{%lecture_systems}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-lecture-systems-updated-by}}', '{{%lecture_systems}}');
        $this->dropForeignKey('{{%fk-lecture-systems-created-by}}', '{{%lecture_systems}}');
        $this->dropTable('{{%lecture_systems}}');
    }
}
