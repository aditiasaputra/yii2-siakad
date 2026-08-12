<?php

use yii\db\Migration;

class m260812_000024_pluralize_domain_table_names extends Migration
{
    private const TABLES = [
        'user' => 'users',
        'role' => 'roles',
        'student' => 'students',
        'employee' => 'employees',
        'lecture' => 'lectures',
        'religion' => 'religions',
        'bank' => 'banks',
        'region' => 'regions',
    ];

    public function up()
    {
        foreach (self::TABLES as $singular => $plural) {
            if ($this->db->schema->getTableSchema("{{%{$singular}}}", true) !== null
                && $this->db->schema->getTableSchema("{{%{$plural}}}", true) === null) {
                $this->renameTable("{{%{$singular}}}", "{{%{$plural}}}");
                $this->db->schema->refresh();
            }
        }
    }

    public function down()
    {
        foreach (array_reverse(self::TABLES, true) as $singular => $plural) {
            if ($this->db->schema->getTableSchema("{{%{$plural}}}", true) !== null
                && $this->db->schema->getTableSchema("{{%{$singular}}}", true) === null) {
                $this->renameTable("{{%{$plural}}}", "{{%{$singular}}}");
                $this->db->schema->refresh();
            }
        }
    }
}
