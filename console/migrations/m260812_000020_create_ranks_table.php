<?php

use yii\db\Migration;

class m260812_000020_create_ranks_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%ranks}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey('{{%fk-ranks-created-by}}', '{{%ranks}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-ranks-updated-by}}', '{{%ranks}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-ranks-updated-by}}', '{{%ranks}}');
        $this->dropForeignKey('{{%fk-ranks-created-by}}', '{{%ranks}}');
        $this->dropTable('{{%ranks}}');
    }
}
