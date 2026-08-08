<?php

use yii\db\Migration;

class m260808_000003_create_education_levels_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%education_levels}}', [
            'id' => $this->primaryKey(),
            'level' => $this->string(20)->notNull()->unique()->comment('Jenjang'),
            'name' => $this->string(255)->notNull()->comment('Nama Tingkat Pendidikan'),
            'sort_order' => $this->smallInteger()->notNull()->unique()->comment('Urutan Tingkat Pendidikan'),
            'is_university' => $this->boolean()->notNull()->defaultValue(false)->comment('Perguruan Tinggi'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-education-levels-created_by}}', '{{%education_levels}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-education-levels-updated_by}}', '{{%education_levels}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-education-levels-updated_by}}', '{{%education_levels}}');
        $this->dropForeignKey('{{%fk-education-levels-created_by}}', '{{%education_levels}}');
        $this->dropTable('{{%education_levels}}');
    }
}
