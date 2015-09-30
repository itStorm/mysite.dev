<?php

use yii\db\Schema;
use yii\db\Migration;

class m150930_213919_timestamp_as_integer_for_articles extends Migration
{
    public function up()
    {
        $this->alterColumn('articles', 'created', Schema::TYPE_INTEGER.' NOT NULL DEFAULT 0');
        $this->alterColumn('articles', 'updated', Schema::TYPE_INTEGER.' NOT NULL DEFAULT 0');
    }

    public function down()
    {
        echo "m150930_213919_timestamp_as_integer_for_articles cannot be reverted.\n";

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
