<?php

use yii\db\Migration;

class m260814_000027_create_fields_of_study_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%fields_of_study}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-fields-of-study-created-by}}', '{{%fields_of_study}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-fields-of-study-updated-by}}', '{{%fields_of_study}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-fields-of-study-updated-by}}', '{{%fields_of_study}}');
        $this->dropForeignKey('{{%fk-fields-of-study-created-by}}', '{{%fields_of_study}}');
        $this->dropTable('{{%fields_of_study}}');
    }
}
