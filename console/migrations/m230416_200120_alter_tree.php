<?php

use yii\db\Migration;

/**
 * Class m230416_200120_alter_tree
 */
class m230416_200120_alter_tree extends Migration
{
    const TABLE_NAME = '{{%tree}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn(self::TABLE_NAME, 'child_allowed', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'child_allowed');
    }
}
