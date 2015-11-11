<?php

use app\components\MyMigration;

class m151111_134915_create_schema extends MyMigration
{
    public function up()
    {
        $this->executeScriptFile(__DIR__ .'/sql/m151111_134915_create_schema.sql');
    }

    public function down()
    {
        echo "m151111_134915_create_schema cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
