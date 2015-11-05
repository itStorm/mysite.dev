<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_210504_add_slug_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'slug', Schema::TYPE_STRING . '(255) DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn('articles', 'slug');
    }
}
