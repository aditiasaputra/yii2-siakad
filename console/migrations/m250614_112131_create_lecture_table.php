<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lecture}}`.
 */
class m250614_112131_create_lecture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lecture}}', [
            'id' => $this->primaryKey(),

            'employee_id' => $this->integer()->notNull(),

            'lecture_nationality_number' => $this->string(10)->null(), // NIDN
            'lecture_special_number' => $this->string(10)->null(), // NIDK
            'teacher_national_number' => $this->string(10)->null(), // NUPN
            'field_of_study' => $this->string()->null(), // Rumpun Ilmu
            'is_match_field' => $this->boolean()->null()->defaultValue(0), // Kesesuaian Rumpun Ilmu?
            'competence' => $this->string()->null(), // Kompetensi
            'certificate_date' => $this->date()->null(), // Tanggal Sertifikat
            'certificate_number' => $this->string()->null(), // No Sertifikat
            'education_number' => $this->integer(16)->null(), // NUPTK

            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
        ]);

        $this->createIndex(
            'idx-lecture-employee_id',
            'lecture',
            'employee_id'
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
