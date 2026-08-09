<?php

use yii\db\Migration;

class m260809_000009_create_academic_activities_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%academic_activities}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'background' => $this->string(7)->null()->comment('Warna kalender akademik'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-academic-activities-created-by}}', '{{%academic_activities}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-academic-activities-updated-by}}', '{{%academic_activities}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-academic-activities-updated-by}}', '{{%academic_activities}}');
        $this->dropForeignKey('{{%fk-academic-activities-created-by}}', '{{%academic_activities}}');
        $this->dropTable('{{%academic_activities}}');
    }
}
