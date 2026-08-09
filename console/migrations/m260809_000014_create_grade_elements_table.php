<?php
use yii\db\Migration;
class m260809_000014_create_grade_elements_table extends Migration { public function safeUp() { $this->createTable('{{%grade_elements}}',['id'=>$this->primaryKey(),'code'=>$this->string(20)->notNull()->unique(),'name'=>$this->string(255)->notNull(),'short_name'=>$this->string(50)->notNull(),'created_at'=>$this->dateTime()->notNull(),'updated_at'=>$this->dateTime()->notNull()]); } public function safeDown() { $this->dropTable('{{%grade_elements}}'); } }
