<?php

use yii\db\Migration;

class m260808_000002_add_detail_columns_to_study_programs_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%study_programs}}', 'short_name', $this->string(50)->null()->after('name'));
        $this->addColumn('{{%study_programs}}', 'name_en', $this->string(255)->null()->after('short_name'));
        $this->addColumn('{{%study_programs}}', 'work_unit', $this->string(255)->null()->after('program_type'));
        $this->addColumn('{{%study_programs}}', 'phone', $this->string(20)->null()->after('work_unit'));
        $this->addColumn('{{%study_programs}}', 'address', $this->text()->null()->after('phone'));
        $this->addColumn('{{%study_programs}}', 'head_of_program', $this->string(255)->null()->after('is_active'));
        $this->addColumn('{{%study_programs}}', 'secretary_of_program', $this->string(255)->null()->after('head_of_program'));
        $this->addColumn('{{%study_programs}}', 'minimum_graduation_credits', $this->smallInteger()->null()->after('nim_sequence_length'));
        $this->addColumn('{{%study_programs}}', 'minimum_graduation_gpa', $this->decimal(3, 2)->null()->after('minimum_graduation_credits'));
        $this->addColumn('{{%study_programs}}', 'degree', $this->string(100)->null()->after('minimum_graduation_gpa'));
        $this->addColumn('{{%study_programs}}', 'degree_abbreviation', $this->string(20)->null()->after('degree'));
    }

    public function safeDown()
    {
        foreach (['degree_abbreviation', 'degree', 'minimum_graduation_gpa', 'minimum_graduation_credits', 'secretary_of_program', 'head_of_program', 'address', 'phone', 'work_unit', 'name_en', 'short_name'] as $column) {
            $this->dropColumn('{{%study_programs}}', $column);
        }
    }
}
