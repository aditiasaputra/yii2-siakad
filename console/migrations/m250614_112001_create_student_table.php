<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student}}`.
 */
class m250614_112001_create_student_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%student}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'father_name' => $this->string()->null(),
            'father_birth_date' => $this->date()->null(),
            'father_education' => $this->string()->null(),
            // 1|Pegawai Negeri Sipil (PNS),2|Pegawai Swasta,3|Wiraswasta/Wirausaha,3|Anggota TNI/POLRI,4|Petani/Nelayan,5|Lainnya
            'father_type_job' => $this->string()->null(),
            // 1|< 500.000,2|500.000 s.d 2.500.000,3|2.500.000 s.d 7.500.000,4|7.500.000 s.d 15.000.000,5|15.000.000 s.d 30.000.000,5|> 30.000.000
            'father_income_range' => $this->string()->null(),
            'father_address' => $this->text()->null(),
            'father_phone' => $this->string(16)->null(),
            'father_email' => $this->string()->null()->unique(),

            'mother_name' => $this->string()->null(),
            'mother_birth_date' => $this->date()->null(),
            'mother_education' => $this->string()->null(),
            // 1|Pegawai Negeri Sipil (PNS),2|Pegawai Swasta,3|Wiraswasta/Wirausaha,3|Anggota TNI/POLRI,4|Petani/Nelayan,5|Lainnya
            'mother_type_job' => $this->string()->null(),
            // 1|< 500.000,2|500.000 s.d 2.500.000,3|2.500.000 s.d 7.500.000,4|7.500.000 s.d 15.000.000,5|15.000.000 s.d 30.000.000,5|> 30.000.000
            'mother_income_range' => $this->string()->null(),
            'mother_address' => $this->text()->null(),
            'mother_phone' => $this->string(16)->null(),
            'mother_email' => $this->string()->null()->unique(),


            'origin_school' => $this->string()->null(),
            'address_school' => $this->text()->null(),
            'province_code_school' => $this->string()->null(),
            'regency_code_school' => $this->string()->null(),
            'phone_school' => $this->string(16)->null(),

            'national_school_identification_number' => $this->string(20)->null(),
            'student_nationality_number' => $this->string(20)->null(),

            // 1|Pegawai Negeri Sipil (PNS),2|Pegawai Swasta,3|Wiraswasta/Wirausaha,3|Anggota TNI/POLRI,4|Petani/Nelayan,5|Lainnya
            'type_job' => $this->string()->null(),
            // 1|< 500.000,2|500.000 s.d 2.500.000,3|2.500.000 s.d 7.500.000,4|7.500.000 s.d 15.000.000,5|15.000.000 s.d 30.000.000,5|> 30.000.000
            'income_range' => $this->string()->null(),
            'workplace_name' => $this->string()->null(),
            
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'deleted_at' => $this->dateTime()->null(),
        ]);

        $this->addForeignKey(
            'fk-student-user_id',
            'student',
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
        $this->dropTable('{{%student}}');
    }
}
