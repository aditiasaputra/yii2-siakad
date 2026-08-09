<?php

use yii\db\Migration;

class m260809_000015_create_jobs_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%jobs}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20)->notNull()->unique()->comment('Kode Pekerjaan'),
            'name' => $this->string(255)->notNull()->comment('Nama Pekerjaan'),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);
        $this->addForeignKey('{{%fk-jobs-created-by}}', '{{%jobs}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
        $this->addForeignKey('{{%fk-jobs-updated-by}}', '{{%jobs}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-jobs-updated-by}}', '{{%jobs}}');
        $this->dropForeignKey('{{%fk-jobs-created-by}}', '{{%jobs}}');
        $this->dropTable('{{%jobs}}');
    }
}
