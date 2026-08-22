<?php

use yii\db\Migration;

class m260821_000037_create_lecture_classes_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%lecture_classes}}', [
            'id' => $this->primaryKey(), 'academic_period' => $this->string(50)->notNull(),
            'study_program_curriculum_id' => $this->integer()->notNull(), 'course_class_id' => $this->integer(),
            'lecture_system_id' => $this->integer()->notNull(), 'name' => $this->string(20)->notNull(),
            'capacity' => $this->integer()->notNull()->defaultValue(40), 'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(), 'meeting_count' => $this->smallInteger()->notNull()->defaultValue(16),
            'created_at' => $this->dateTime(), 'updated_at' => $this->dateTime(), 'created_by' => $this->integer(), 'updated_by' => $this->integer(),
        ]);
        $this->createIndex('{{%uq-lecture-classes-period-curriculum-name}}', '{{%lecture_classes}}', ['academic_period', 'study_program_curriculum_id', 'name'], true);
        $this->addForeignKey('{{%fk-lecture-classes-curriculum}}', '{{%lecture_classes}}', 'study_program_curriculum_id', '{{%study_program_curricula}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('{{%fk-lecture-classes-course-class}}', '{{%lecture_classes}}', 'course_class_id', '{{%course_classes}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('{{%fk-lecture-classes-system}}', '{{%lecture_classes}}', 'lecture_system_id', '{{%lecture_systems}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('{{%fk-lecture-classes-created-by}}', '{{%lecture_classes}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-lecture-classes-updated-by}}', '{{%lecture_classes}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');

        $this->createTable('{{%lecture_class_lecturers}}', ['lecture_class_id' => $this->integer()->notNull(), 'lecturer_id' => $this->integer()->notNull()]);
        $this->addPrimaryKey('{{%pk-lecture-class-lecturers}}', '{{%lecture_class_lecturers}}', ['lecture_class_id', 'lecturer_id']);
        $this->addForeignKey('{{%fk-lecture-class-lecturers-class}}', '{{%lecture_class_lecturers}}', 'lecture_class_id', '{{%lecture_classes}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-lecture-class-lecturers-lecturer}}', '{{%lecture_class_lecturers}}', 'lecturer_id', '{{%lectures}}', 'id', 'CASCADE');

        $this->createTable('{{%lecture_class_schedules}}', [
            'id' => $this->primaryKey(), 'lecture_class_id' => $this->integer()->notNull(), 'weekday' => $this->smallInteger()->notNull(),
            'start_time_slot_id' => $this->integer()->notNull(), 'end_time_slot_id' => $this->integer()->notNull(), 'lecture_room_id' => $this->integer(),
        ]);
        $this->addForeignKey('{{%fk-lecture-class-schedules-class}}', '{{%lecture_class_schedules}}', 'lecture_class_id', '{{%lecture_classes}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-lecture-class-schedules-start}}', '{{%lecture_class_schedules}}', 'start_time_slot_id', '{{%time_slots}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-lecture-class-schedules-end}}', '{{%lecture_class_schedules}}', 'end_time_slot_id', '{{%time_slots}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-lecture-class-schedules-room}}', '{{%lecture_class_schedules}}', 'lecture_room_id', '{{%lecture_rooms}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropTable('{{%lecture_class_schedules}}'); $this->dropTable('{{%lecture_class_lecturers}}'); $this->dropTable('{{%lecture_classes}}');
    }
}
