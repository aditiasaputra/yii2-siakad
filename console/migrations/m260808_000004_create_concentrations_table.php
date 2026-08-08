<?php
use yii\db\Migration;

class m260808_000004_create_concentrations_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%concentrations}}', [
            'id' => $this->primaryKey(),
            'study_program_id' => $this->integer()->notNull(),
            'code' => $this->string(20)->notNull(),
            'name' => $this->string(255)->notNull(),
            'name_en' => $this->string(255)->null(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->createIndex('{{%idx-concentrations-study-program-code}}', '{{%concentrations}}', ['study_program_id', 'code'], true);
        $this->addForeignKey('{{%fk-concentrations-study_program_id}}', '{{%concentrations}}', 'study_program_id', '{{%study_programs}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-concentrations-created_by}}', '{{%concentrations}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-concentrations-updated_by}}', '{{%concentrations}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-concentrations-updated_by}}', '{{%concentrations}}');
        $this->dropForeignKey('{{%fk-concentrations-created_by}}', '{{%concentrations}}');
        $this->dropForeignKey('{{%fk-concentrations-study_program_id}}', '{{%concentrations}}');
        $this->dropIndex('{{%idx-concentrations-study-program-code}}', '{{%concentrations}}');
        $this->dropTable('{{%concentrations}}');
    }
}
