<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
        ]);

        $this->batchInsert('{{%role}}', ['name'], [
            ['administrator'],
            ['operator'],
            ['staff'],
            ['lecturer'],
            ['student'],
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'username' => $this->string()->notNull()->unique(),
            'honorific' => $this->string(255)->null(), // Gelar Depan
            'degree' => $this->string(255)->null(), // Gelar Belakang
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'personal_id' => $this->string()->null(), // KTP
            'family_id' => $this->string()->null(), // KK
            // 1|Admin,2|Operator,3|Staff,4|Lecturer,5|Student
            'role_id' => $this->integer()->notNull()->defaultValue(5),
            'image' => $this->string()->null(),
            'gender' => $this->integer()->notNull()->defaultValue(0),
            'place_of_birth' => $this->string()->null(),
            'birth_date' => $this->date()->null(),
            'address' => $this->text()->null(),
            'phone' => $this->string(16)->null(),
            'blood_type' => $this->string(255)->null(), // Golongan Darah
            'height' => $this->string(3)->null(), // Tinggi
            'weight' => $this->string(3)->null(), // Berat
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-user-role_id',
            '{{%user}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
