<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 */
class m250614_112130_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'employee_number' => $this->string(255)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'tax_id' => $this->integer()->null(),
            'bank_id' => $this->integer()->null(),
            'branch_name' => $this->string(255)->null(),
            'account_number' => $this->string(255)->null(),
            'account_name' => $this->string(255)->null(),
            'national_social_security_number' => $this->string(16)->null(),
            'national_health_insurance_number' => $this->string(16)->null(),
            'social_security_number' => $this->string(16)->null(),
            'health_insurance_number' => $this->string(16)->null(),
            'note' => $this->text()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee}}');
    }
}
