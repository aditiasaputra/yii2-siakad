<?php

use yii\db\Migration;

class m260812_000021_create_functional_positions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%functional_positions}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(2)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-functional-positions-created-by}}', '{{%functional_positions}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-functional-positions-updated-by}}', '{{%functional_positions}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-functional-positions-updated-by}}', '{{%functional_positions}}');
        $this->dropForeignKey('{{%fk-functional-positions-created-by}}', '{{%functional_positions}}');
        $this->dropTable('{{%functional_positions}}');
    }
}
