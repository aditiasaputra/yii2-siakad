<?php

use yii\db\Migration;

class m260821_000036_create_subject_equivalences_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subject_equivalences}}', [
            'id' => $this->primaryKey(),
            'study_program_id' => $this->integer()->notNull(),
            'new_curriculum_year_id' => $this->integer()->notNull(),
            'old_curriculum_year_id' => $this->integer()->notNull(),
            'new_subject_id' => $this->integer()->notNull(),
            'old_subject_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createIndex('{{%uq-subject-equivalences-pair}}', '{{%subject_equivalences}}', ['new_subject_id', 'old_subject_id'], true);
        $this->addForeignKey('{{%fk-subject-equivalences-program}}', '{{%subject_equivalences}}', 'study_program_id', '{{%study_programs}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-subject-equivalences-new-year}}', '{{%subject_equivalences}}', 'new_curriculum_year_id', '{{%curriculum_years}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-subject-equivalences-old-year}}', '{{%subject_equivalences}}', 'old_curriculum_year_id', '{{%curriculum_years}}', 'id', 'RESTRICT');
        $this->addForeignKey('{{%fk-subject-equivalences-new-subject}}', '{{%subject_equivalences}}', 'new_subject_id', '{{%subjects}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-subject-equivalences-old-subject}}', '{{%subject_equivalences}}', 'old_subject_id', '{{%subjects}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-subject-equivalences-created-by}}', '{{%subject_equivalences}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-subject-equivalences-updated-by}}', '{{%subject_equivalences}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropTable('{{%subject_equivalences}}');
    }
}
