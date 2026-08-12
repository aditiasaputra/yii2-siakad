<?php

use yii\db\Migration;

class m260812_000023_create_countries_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(3)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-countries-created-by}}', '{{%countries}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-countries-updated-by}}', '{{%countries}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-countries-updated-by}}', '{{%countries}}');
        $this->dropForeignKey('{{%fk-countries-created-by}}', '{{%countries}}');
        $this->dropTable('{{%countries}}');
    }
}
