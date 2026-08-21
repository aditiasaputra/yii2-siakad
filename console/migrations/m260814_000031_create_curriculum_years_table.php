<?php

use yii\db\Migration;

class m260814_000031_create_curriculum_years_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%curriculum_years}}', [
            'id' => $this->primaryKey(),
            'year' => $this->smallInteger()->unsigned()->notNull()->unique(),
            'description' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-curriculum-years-created-by}}', '{{%curriculum_years}}', 'created_by', '{{%users}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-curriculum-years-updated-by}}', '{{%curriculum_years}}', 'updated_by', '{{%users}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-curriculum-years-updated-by}}', '{{%curriculum_years}}');
        $this->dropForeignKey('{{%fk-curriculum-years-created-by}}', '{{%curriculum_years}}');
        $this->dropTable('{{%curriculum_years}}');
    }
}
