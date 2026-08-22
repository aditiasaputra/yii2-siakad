<?php
use yii\db\Migration;
class m260822_000041_create_student_semester_statuses_table extends Migration
{
    public function safeUp(){
        $this->createTable('{{%student_semester_statuses}}',['id'=>$this->primaryKey(),'student_id'=>$this->integer()->notNull(),'academic_period'=>$this->string(50)->notNull(),'study_program_id'=>$this->integer()->notNull(),'semester'=>$this->smallInteger()->notNull()->defaultValue(1),'status'=>$this->string(20)->notNull(),'notes'=>$this->text(),'created_at'=>$this->dateTime()->notNull(),'updated_at'=>$this->dateTime()->notNull(),'created_by'=>$this->integer(),'updated_by'=>$this->integer()]);
        $this->createIndex('{{%uq-student-semester-status}}','{{%student_semester_statuses}}',['student_id','academic_period'],true);
        $this->addForeignKey('{{%fk-semester-status-student}}','{{%student_semester_statuses}}','student_id','{{%students}}','id','CASCADE');
        $this->addForeignKey('{{%fk-semester-status-program}}','{{%student_semester_statuses}}','study_program_id','{{%study_programs}}','id','RESTRICT');
        $this->addForeignKey('{{%fk-semester-status-created-by}}','{{%student_semester_statuses}}','created_by','{{%users}}','id','SET NULL');
        $this->addForeignKey('{{%fk-semester-status-updated-by}}','{{%student_semester_statuses}}','updated_by','{{%users}}','id','SET NULL');
    }
    public function safeDown(){$this->dropTable('{{%student_semester_statuses}}');}
}
