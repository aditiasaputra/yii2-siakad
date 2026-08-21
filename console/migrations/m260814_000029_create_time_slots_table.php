<?php

use yii\db\Migration;

class m260814_000029_create_time_slots_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%time_slots}}', [
            'id' => $this->primaryKey(),
            'time' => $this->time()->notNull()->unique(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-time-slots-created-by}}', '{{%time_slots}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-time-slots-updated-by}}', '{{%time_slots}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-time-slots-updated-by}}', '{{%time_slots}}');
        $this->dropForeignKey('{{%fk-time-slots-created-by}}', '{{%time_slots}}');
        $this->dropTable('{{%time_slots}}');
    }
}
