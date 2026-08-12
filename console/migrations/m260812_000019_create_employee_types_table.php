<?php

use yii\db\Migration;

class m260812_000019_create_employee_types_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%employee_types}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-employee-types-created-by}}', '{{%employee_types}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-employee-types-updated-by}}', '{{%employee_types}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-employee-types-updated-by}}', '{{%employee_types}}');
        $this->dropForeignKey('{{%fk-employee-types-created-by}}', '{{%employee_types}}');
        $this->dropTable('{{%employee_types}}');
    }
}
