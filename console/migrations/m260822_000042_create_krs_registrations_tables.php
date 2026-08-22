<?php
use yii\db\Migration;
class m260822_000042_create_krs_registrations_tables extends Migration
{
    public function safeUp(){
        $this->createTable('{{%krs_registrations}}',['id'=>$this->primaryKey(),'student_id'=>$this->integer()->notNull(),'academic_period'=>$this->string(50)->notNull(),'study_program_id'=>$this->integer()->notNull(),'semester'=>$this->smallInteger()->notNull(),'maximum_credits'=>$this->smallInteger()->notNull()->defaultValue(24),'status'=>$this->string(20)->notNull()->defaultValue('draft'),'validated_at'=>$this->dateTime(),'validated_by'=>$this->integer(),'notes'=>$this->text(),'created_at'=>$this->dateTime()->notNull(),'updated_at'=>$this->dateTime()->notNull(),'created_by'=>$this->integer(),'updated_by'=>$this->integer()]);
        $this->createIndex('{{%uq-krs-registration-student-period}}','{{%krs_registrations}}',['student_id','academic_period'],true);
        $this->addForeignKey('{{%fk-krs-registration-student}}','{{%krs_registrations}}','student_id','{{%students}}','id','CASCADE');$this->addForeignKey('{{%fk-krs-registration-program}}','{{%krs_registrations}}','study_program_id','{{%study_programs}}','id','RESTRICT');$this->addForeignKey('{{%fk-krs-registration-validator}}','{{%krs_registrations}}','validated_by','{{%users}}','id','SET NULL');
        $this->createTable('{{%krs_registration_items}}',['id'=>$this->primaryKey(),'krs_registration_id'=>$this->integer()->notNull(),'lecture_class_id'=>$this->integer()->notNull(),'created_at'=>$this->dateTime()->notNull()]);
        $this->createIndex('{{%uq-krs-registration-class}}','{{%krs_registration_items}}',['krs_registration_id','lecture_class_id'],true);$this->addForeignKey('{{%fk-krs-item-registration}}','{{%krs_registration_items}}','krs_registration_id','{{%krs_registrations}}','id','CASCADE');$this->addForeignKey('{{%fk-krs-item-class}}','{{%krs_registration_items}}','lecture_class_id','{{%lecture_classes}}','id','CASCADE');
    }
    public function safeDown(){$this->dropTable('{{%krs_registration_items}}');$this->dropTable('{{%krs_registrations}}');}
}
