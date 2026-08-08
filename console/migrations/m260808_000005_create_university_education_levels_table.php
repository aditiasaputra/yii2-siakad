<?php
use yii\db\Migration;
class m260808_000005_create_university_education_levels_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%university_education_levels}}', ['id' => $this->primaryKey(), 'education_level_id' => $this->integer()->notNull()->unique(), 'study_period_semesters' => $this->smallInteger()->notNull(), 'max_leave_semesters' => $this->smallInteger()->notNull(), 'max_study_semesters' => $this->smallInteger()->notNull(), 'created_at' => $this->dateTime()->notNull(), 'updated_at' => $this->dateTime()->notNull(), 'created_by' => $this->integer()->null(), 'updated_by' => $this->integer()->null()]);
        $this->addForeignKey('{{%fk-university-education-levels-education-level}}', '{{%university_education_levels}}', 'education_level_id', '{{%education_levels}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-university-education-levels-created-by}}', '{{%university_education_levels}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-university-education-levels-updated-by}}', '{{%university_education_levels}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }
    public function safeDown() { $this->dropForeignKey('{{%fk-university-education-levels-updated-by}}', '{{%university_education_levels}}'); $this->dropForeignKey('{{%fk-university-education-levels-created-by}}', '{{%university_education_levels}}'); $this->dropForeignKey('{{%fk-university-education-levels-education-level}}', '{{%university_education_levels}}'); $this->dropTable('{{%university_education_levels}}'); }
}
