<?php
use yii\db\Migration;
class m260822_000039_create_krs_blocks_table extends Migration
{
    public function safeUp(){
        $this->createTable('{{%krs_blocks}}',['id'=>$this->primaryKey(),'student_id'=>$this->integer()->notNull(),'academic_period'=>$this->string(50)->notNull(),'study_program_id'=>$this->integer()->notNull(),'entry_year'=>$this->smallInteger()->notNull(),'current_semester'=>$this->smallInteger()->notNull()->defaultValue(1),'academic_block'=>$this->boolean()->notNull()->defaultValue(false),'finance_block'=>$this->boolean()->notNull()->defaultValue(false),'library_block'=>$this->boolean()->notNull()->defaultValue(false),'student_affairs_block'=>$this->boolean()->notNull()->defaultValue(false),'notes'=>$this->text(),'created_at'=>$this->dateTime()->notNull(),'updated_at'=>$this->dateTime()->notNull(),'created_by'=>$this->integer(),'updated_by'=>$this->integer()]);
        $this->createIndex('{{%uq-krs-block-student-period}}','{{%krs_blocks}}',['student_id','academic_period'],true);
        $this->addForeignKey('{{%fk-krs-block-student}}','{{%krs_blocks}}','student_id','{{%students}}','id','CASCADE');
        $this->addForeignKey('{{%fk-krs-block-program}}','{{%krs_blocks}}','study_program_id','{{%study_programs}}','id','RESTRICT');
        $this->addForeignKey('{{%fk-krs-block-created-by}}','{{%krs_blocks}}','created_by','{{%users}}','id','SET NULL');
        $this->addForeignKey('{{%fk-krs-block-updated-by}}','{{%krs_blocks}}','updated_by','{{%users}}','id','SET NULL');
    }
    public function safeDown(){$this->dropTable('{{%krs_blocks}}');}
}
