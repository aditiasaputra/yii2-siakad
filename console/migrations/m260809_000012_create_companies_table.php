<?php
use yii\db\Migration;
class m260809_000012_create_companies_table extends Migration { public function safeUp() { $this->createTable('{{%companies}}', ['id' => $this->primaryKey(), 'number' => $this->string(20)->notNull()->unique(), 'name' => $this->string(255)->notNull(), 'address' => $this->text()->notNull(), 'phone' => $this->string(30)->notNull(), 'created_at' => $this->dateTime()->notNull(), 'updated_at' => $this->dateTime()->notNull()]); } public function safeDown() { $this->dropTable('{{%companies}}'); } }
