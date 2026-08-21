<?php

use yii\db\Migration;

class m260814_000028_create_course_classes_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%course_classes}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-course-classes-created-by}}', '{{%course_classes}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-course-classes-updated-by}}', '{{%course_classes}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-course-classes-updated-by}}', '{{%course_classes}}');
        $this->dropForeignKey('{{%fk-course-classes-created-by}}', '{{%course_classes}}');
        $this->dropTable('{{%course_classes}}');
    }
}
