<?php

use yii\db\Migration;

class m260814_000033_create_study_program_curricula_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%study_program_curricula}}', [
            'id' => $this->primaryKey(),
            'study_program_id' => $this->integer()->notNull(),
            'curriculum_year_id' => $this->integer()->notNull(),
            'subject_id' => $this->integer()->notNull(),
            'semester' => $this->smallInteger()->notNull(),
            'minimum_grade' => $this->string(2)->notNull()->defaultValue('E'),
            'is_mandatory' => $this->boolean()->notNull()->defaultValue(true),
            'is_package' => $this->boolean()->notNull()->defaultValue(false),
            'topic' => $this->text()->null(),
            'basic_competencies' => $this->text()->null(),
            'minimum_credits' => $this->decimal(4, 1)->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%uq-program-curricula-subject}}', '{{%study_program_curricula}}', ['study_program_id', 'curriculum_year_id', 'subject_id'], true);
        $this->addForeignKey('{{%fk-program-curricula-program}}', '{{%study_program_curricula}}', 'study_program_id', '{{%study_programs}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-program-curricula-year}}', '{{%study_program_curricula}}', 'curriculum_year_id', '{{%curriculum_years}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-program-curricula-subject}}', '{{%study_program_curricula}}', 'subject_id', '{{%subjects}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-program-curricula-created-by}}', '{{%study_program_curricula}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-program-curricula-updated-by}}', '{{%study_program_curricula}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        foreach (['updated-by', 'created-by', 'subject', 'year', 'program'] as $key) {
            $this->dropForeignKey('{{%fk-program-curricula-' . $key . '}}', '{{%study_program_curricula}}');
        }
        $this->dropTable('{{%study_program_curricula}}');
    }
}
