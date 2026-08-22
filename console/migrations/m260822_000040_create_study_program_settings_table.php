<?php
use yii\db\Migration;
class m260822_000040_create_study_program_settings_table extends Migration
{
    public function safeUp(){
        $this->createTable('{{%study_program_settings}}',['id'=>$this->primaryKey(),'academic_period'=>$this->string(50)->notNull(),'study_program_id'=>$this->integer()->notNull(),'new_student_curriculum_year_id'=>$this->integer(),'krs_enabled'=>$this->boolean()->notNull()->defaultValue(false),'krs_validation_enabled'=>$this->boolean()->notNull()->defaultValue(false),'khs_enabled'=>$this->boolean()->notNull()->defaultValue(false),'grading_enabled'=>$this->boolean()->notNull()->defaultValue(false),'questionnaire_enabled'=>$this->boolean()->notNull()->defaultValue(false),'lecturer_meeting_generation_enabled'=>$this->boolean()->notNull()->defaultValue(false),'notes'=>$this->text(),'created_at'=>$this->dateTime()->notNull(),'updated_at'=>$this->dateTime()->notNull(),'created_by'=>$this->integer(),'updated_by'=>$this->integer()]);
        $this->createIndex('{{%uq-program-setting-period}}','{{%study_program_settings}}',['academic_period','study_program_id'],true);
        $this->addForeignKey('{{%fk-program-setting-program}}','{{%study_program_settings}}','study_program_id','{{%study_programs}}','id','CASCADE');
        $this->addForeignKey('{{%fk-program-setting-curriculum}}','{{%study_program_settings}}','new_student_curriculum_year_id','{{%curriculum_years}}','id','SET NULL');
        $this->addForeignKey('{{%fk-program-setting-created-by}}','{{%study_program_settings}}','created_by','{{%users}}','id','SET NULL');
        $this->addForeignKey('{{%fk-program-setting-updated-by}}','{{%study_program_settings}}','updated_by','{{%users}}','id','SET NULL');
    }
    public function safeDown(){$this->dropTable('{{%study_program_settings}}');}
}
