<?php

use yii\db\Migration;

class m260814_000025_create_subject_types_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subject_types}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(5)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-subject-types-created-by}}', '{{%subject_types}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-subject-types-updated-by}}', '{{%subject_types}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-subject-types-updated-by}}', '{{%subject_types}}');
        $this->dropForeignKey('{{%fk-subject-types-created-by}}', '{{%subject_types}}');
        $this->dropTable('{{%subject_types}}');
    }
}
