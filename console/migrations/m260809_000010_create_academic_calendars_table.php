<?php
use yii\db\Migration;
class m260809_000010_create_academic_calendars_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%academic_calendars}}', [
            'id' => $this->primaryKey(), 'period' => $this->string(50)->notNull(), 'academic_activity_id' => $this->integer()->notNull(),
            'start_date' => $this->date()->notNull(), 'end_date' => $this->date()->notNull(), 'description' => $this->text()->notNull(),
            'is_academic_holiday' => $this->boolean()->notNull()->defaultValue(false), 'is_national_holiday' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull(), 'updated_at' => $this->dateTime()->notNull(), 'created_by' => $this->integer()->null(), 'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-academic-calendars-activity}}', '{{%academic_calendars}}', 'academic_activity_id', '{{%academic_activities}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('{{%fk-academic-calendars-created-by}}', '{{%academic_calendars}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-academic-calendars-updated-by}}', '{{%academic_calendars}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-academic-calendars-updated-by}}', '{{%academic_calendars}}'); $this->dropForeignKey('{{%fk-academic-calendars-created-by}}', '{{%academic_calendars}}'); $this->dropForeignKey('{{%fk-academic-calendars-activity}}', '{{%academic_calendars}}'); $this->dropTable('{{%academic_calendars}}');
    }
}
