<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lecture}}`.
 */
class m250614_112138_create_lecture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lecture}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull()->unique(),
            'employee_id' => $this->string(10)->notNull()->unique(),

            'lecture_nationality_number' => $this->string(10)->null()->unique(), // NIDN
            'lecture_special_number' => $this->string(10)->null()->unique(), // NIDK
            'teacher_national_number' => $this->string(10)->null()->unique(), // NUPN
            'field_of_study' => $this->string()->null()->unique(), // Rumpun Ilmu
            'is_match_field' => $this->boolean()->notNull()->defaultValue(0), // Kesesuaian Rumpun Ilmu?
            'competence' => $this->string()->null()->unique(), // Kompetensi
            'certificate_date' => $this->date()->null(), // Tanggal Sertifikat
            'certificate_number' => $this->string()->null()->unique(), // No Sertifikat
            'education_number' => $this->integer(16)->null(), // NUPTK

            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey(
            'fk-lecture-user_id',
            'lecture',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lecture}}');
    }
}
