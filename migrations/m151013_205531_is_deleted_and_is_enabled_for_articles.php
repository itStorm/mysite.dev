<?php

use yii\db\Schema;
use yii\db\Migration;

class m151013_205531_is_deleted_and_is_enabled_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'is_deleted', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE');
        $this->addColumn('articles', 'is_enabled', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE');
    }

    public function down()
    {
        $this->dropColumn('articles', 'is_deleted');
        $this->dropColumn('articles', 'is_enabled');
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
