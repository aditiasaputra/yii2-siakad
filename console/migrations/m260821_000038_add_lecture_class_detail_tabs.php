<?php
use yii\db\Migration;
class m260821_000038_add_lecture_class_detail_tabs extends Migration
{
    public function safeUp(){
        $this->addColumn('{{%lecture_classes}}','contract_content',$this->text()->after('meeting_count'));
        $this->addColumn('{{%lecture_class_lecturers}}','is_coordinator',$this->boolean()->notNull()->defaultValue(false));
        $this->createTable('{{%lecture_class_meetings}}',['id'=>$this->primaryKey(),'lecture_class_id'=>$this->integer()->notNull(),'meeting_number'=>$this->smallInteger()->notNull(),'schedule_date'=>$this->date()->notNull(),'start_time_slot_id'=>$this->integer()->notNull(),'end_time_slot_id'=>$this->integer()->notNull(),'lecture_room_id'=>$this->integer(),'lecturer_id'=>$this->integer(),'status'=>$this->string(20)->notNull()->defaultValue('scheduled'),'credits'=>$this->decimal(5,2),'location'=>$this->string(255),'meeting_type'=>$this->string(30)->notNull()->defaultValue('lecture'),'planned_material'=>$this->text(),'realized_material'=>$this->text(),'attachment'=>$this->string(255)]);
        $this->createIndex('{{%uq-lecture-class-meeting-number}}','{{%lecture_class_meetings}}',['lecture_class_id','meeting_number'],true);
        $this->addForeignKey('{{%fk-lecture-class-meetings-class}}','{{%lecture_class_meetings}}','lecture_class_id','{{%lecture_classes}}','id','CASCADE');
        $this->addForeignKey('{{%fk-lecture-class-meetings-start}}','{{%lecture_class_meetings}}','start_time_slot_id','{{%time_slots}}','id','RESTRICT');
        $this->addForeignKey('{{%fk-lecture-class-meetings-end}}','{{%lecture_class_meetings}}','end_time_slot_id','{{%time_slots}}','id','RESTRICT');
        $this->addForeignKey('{{%fk-lecture-class-meetings-room}}','{{%lecture_class_meetings}}','lecture_room_id','{{%lecture_rooms}}','id','SET NULL');
        $this->addForeignKey('{{%fk-lecture-class-meetings-lecturer}}','{{%lecture_class_meetings}}','lecturer_id','{{%lectures}}','id','SET NULL');
    }
    public function safeDown(){$this->dropTable('{{%lecture_class_meetings}}');$this->dropColumn('{{%lecture_class_lecturers}}','is_coordinator');$this->dropColumn('{{%lecture_classes}}','contract_content');}
}
