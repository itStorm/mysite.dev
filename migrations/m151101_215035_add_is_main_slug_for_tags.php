<?php

use yii\db\Schema;
use yii\db\Migration;

class m151101_215035_add_is_main_slug_for_tags extends Migration
{
    public function up()
    {
        $this->addColumn('tags', 'is_main', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE');
        $this->addColumn('tags', 'slug', Schema::TYPE_STRING . '(255) DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn('tags', 'is_main');
        $this->dropColumn('tags', 'slug');
    }
}
