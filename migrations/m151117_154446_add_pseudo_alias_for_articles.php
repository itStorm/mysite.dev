<?php

use yii\db\Schema;
use yii\db\Migration;

class m151117_154446_add_pseudo_alias_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'pseudo_alias', Schema::TYPE_STRING . '(255) NOT NULL DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn('articles', 'pseudo_alias');
    }
}
