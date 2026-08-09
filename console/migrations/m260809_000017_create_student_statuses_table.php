<?php

use yii\db\Migration;

class m260809_000017_create_student_statuses_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%student_statuses}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull()->unique()->comment('Kode Status Mahasiswa'),
            'name' => $this->string(255)->notNull()->comment('Nama Status Mahasiswa'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-student-statuses-created-by}}', '{{%student_statuses}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-student-statuses-updated-by}}', '{{%student_statuses}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-student-statuses-updated-by}}', '{{%student_statuses}}');
        $this->dropForeignKey('{{%fk-student-statuses-created-by}}', '{{%student_statuses}}');
        $this->dropTable('{{%student_statuses}}');
    }
}
