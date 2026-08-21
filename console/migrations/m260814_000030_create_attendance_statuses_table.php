<?php

use yii\db\Migration;

class m260814_000030_create_attendance_statuses_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%attendance_statuses}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(5)->notNull()->unique(),
            'name' => $this->string(100)->notNull(),
            'counts_as_present' => $this->boolean()->notNull()->defaultValue(false),
            'applies_to_lecturers' => $this->boolean()->notNull()->defaultValue(false),
            'applies_to_students' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-attendance-statuses-created-by}}', '{{%attendance_statuses}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-attendance-statuses-updated-by}}', '{{%attendance_statuses}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-attendance-statuses-updated-by}}', '{{%attendance_statuses}}');
        $this->dropForeignKey('{{%fk-attendance-statuses-created-by}}', '{{%attendance_statuses}}');
        $this->dropTable('{{%attendance_statuses}}');
    }
}
