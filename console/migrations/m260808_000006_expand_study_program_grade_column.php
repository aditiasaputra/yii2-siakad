<?php

use yii\db\Migration;

class m260808_000006_expand_study_program_grade_column extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%study_programs}}', 'grade', $this->string(20)->null()->comment('Akreditasi/Grade'));
    }

    public function safeDown()
    {
        $this->alterColumn('{{%study_programs}}', 'grade', $this->string(10)->null()->comment('Akreditasi/Grade'));
    }
}
