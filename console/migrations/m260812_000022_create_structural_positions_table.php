<?php

use yii\db\Migration;

class m260812_000022_create_structural_positions_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%structural_positions}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(3)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-structural-positions-created-by}}', '{{%structural_positions}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-structural-positions-updated-by}}', '{{%structural_positions}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-structural-positions-updated-by}}', '{{%structural_positions}}');
        $this->dropForeignKey('{{%fk-structural-positions-created-by}}', '{{%structural_positions}}');
        $this->dropTable('{{%structural_positions}}');
    }
}
