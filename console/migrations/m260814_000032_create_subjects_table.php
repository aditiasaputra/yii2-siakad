<?php

use yii\db\Migration;

class m260814_000032_create_subjects_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subjects}}', [
            'id' => $this->primaryKey(),
            'curriculum_year_id' => $this->integer()->notNull(),
            'code' => $this->string(30)->notNull(),
            'name' => $this->string(255)->notNull(),
            'name_en' => $this->string(255)->null(),
            'subject_type_id' => $this->integer()->notNull(),
            'subject_group_id' => $this->integer()->notNull(),
            'study_program_id' => $this->integer()->notNull(),
            'credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'face_to_face_credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'practicum_credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'lab_credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'ksk_credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'pbl_credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'mku' => $this->string(255)->null(),
            'sap' => $this->string(255)->null(),
            'syllabus' => $this->string(255)->null(),
            'teaching_material' => $this->string(255)->null(),
            'module' => $this->string(255)->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%uq-subjects-curriculum-code}}', '{{%subjects}}', ['curriculum_year_id', 'code'], true);
        $this->addForeignKey('{{%fk-subjects-curriculum-year}}', '{{%subjects}}', 'curriculum_year_id', '{{%curriculum_years}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-subjects-subject-type}}', '{{%subjects}}', 'subject_type_id', '{{%subject_types}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-subjects-subject-group}}', '{{%subjects}}', 'subject_group_id', '{{%subject_groups}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-subjects-study-program}}', '{{%subjects}}', 'study_program_id', '{{%study_programs}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-subjects-created-by}}', '{{%subjects}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-subjects-updated-by}}', '{{%subjects}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');

        $this->createTable('{{%subject_lecturers}}', [
            'subject_id' => $this->integer()->notNull(),
            'lecturer_id' => $this->integer()->notNull(),
            'PRIMARY KEY(subject_id, lecturer_id)',
        ]);
        $this->addForeignKey('{{%fk-subject-lecturers-subject}}', '{{%subject_lecturers}}', 'subject_id', '{{%subjects}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-subject-lecturers-lecturer}}', '{{%subject_lecturers}}', 'lecturer_id', '{{%lectures}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-subject-lecturers-lecturer}}', '{{%subject_lecturers}}');
        $this->dropForeignKey('{{%fk-subject-lecturers-subject}}', '{{%subject_lecturers}}');
        $this->dropTable('{{%subject_lecturers}}');
        foreach (['updated-by', 'created-by', 'study-program', 'subject-group', 'subject-type', 'curriculum-year'] as $key) {
            $this->dropForeignKey('{{%fk-subjects-' . $key . '}}', '{{%subjects}}');
        }
        $this->dropTable('{{%subjects}}');
    }
}
