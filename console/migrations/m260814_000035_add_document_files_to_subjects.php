<?php

use yii\db\Migration;

class m260814_000035_add_document_files_to_subjects extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%subjects}}', 'syllabus_file', $this->string(255)->null()->after('syllabus'));
        $this->addColumn('{{%subjects}}', 'material_details_file', $this->string(255)->null()->after('syllabus_file'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%subjects}}', 'material_details_file');
        $this->dropColumn('{{%subjects}}', 'syllabus_file');
    }
}
