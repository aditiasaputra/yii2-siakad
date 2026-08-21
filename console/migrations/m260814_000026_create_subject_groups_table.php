<?php

use yii\db\Migration;

class m260814_000026_create_subject_groups_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subject_groups}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(5)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-subject-groups-created-by}}', '{{%subject_groups}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-subject-groups-updated-by}}', '{{%subject_groups}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-subject-groups-updated-by}}', '{{%subject_groups}}');
        $this->dropForeignKey('{{%fk-subject-groups-created-by}}', '{{%subject_groups}}');
        $this->dropTable('{{%subject_groups}}');
    }
}
