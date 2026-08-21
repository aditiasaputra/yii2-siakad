<?php

use yii\db\Migration;

class m260814_000034_create_subject_prerequisites_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subject_prerequisites}}', [
            'id' => $this->primaryKey(),
            'course_curriculum_id' => $this->integer()->notNull(),
            'prerequisite_curriculum_id' => $this->integer()->notNull(),
            'requirement_type' => $this->string(20)->notNull()->defaultValue('passed'),
            'minimum_grade' => $this->string(2)->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%uq-subject-prerequisites-pair}}', '{{%subject_prerequisites}}', ['course_curriculum_id', 'prerequisite_curriculum_id'], true);
        $this->addForeignKey('{{%fk-subject-prerequisites-course}}', '{{%subject_prerequisites}}', 'course_curriculum_id', '{{%study_program_curricula}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-subject-prerequisites-prerequisite}}', '{{%subject_prerequisites}}', 'prerequisite_curriculum_id', '{{%study_program_curricula}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-subject-prerequisites-created-by}}', '{{%subject_prerequisites}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-subject-prerequisites-updated-by}}', '{{%subject_prerequisites}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        foreach (['updated-by', 'created-by', 'prerequisite', 'course'] as $key) {
            $this->dropForeignKey('{{%fk-subject-prerequisites-' . $key . '}}', '{{%subject_prerequisites}}');
        }
        $this->dropTable('{{%subject_prerequisites}}');
    }
}
