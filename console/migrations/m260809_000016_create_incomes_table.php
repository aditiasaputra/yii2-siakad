<?php

use yii\db\Migration;

class m260809_000016_create_incomes_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%incomes}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique()->comment('Kode Penghasilan'),
            'name' => $this->string(255)->notNull()->comment('Nama Penghasilan'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-incomes-created-by}}', '{{%incomes}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-incomes-updated-by}}', '{{%incomes}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-incomes-updated-by}}', '{{%incomes}}');
        $this->dropForeignKey('{{%fk-incomes-created-by}}', '{{%incomes}}');
        $this->dropTable('{{%incomes}}');
    }
}
