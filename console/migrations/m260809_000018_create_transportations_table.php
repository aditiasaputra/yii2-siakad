<?php

use yii\db\Migration;

class m260809_000018_create_transportations_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%transportations}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime()->notNull(), 'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(), 'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-transportations-created-by}}', '{{%transportations}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-transportations-updated-by}}', '{{%transportations}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-transportations-updated-by}}', '{{%transportations}}');
        $this->dropForeignKey('{{%fk-transportations-created-by}}', '{{%transportations}}');
        $this->dropTable('{{%transportations}}');
    }
}
