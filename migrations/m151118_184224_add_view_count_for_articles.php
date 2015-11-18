<?php

use yii\db\Schema;
use yii\db\Migration;

class m151118_184224_add_view_count_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'view_count', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('articles', 'view_count');
    }
}
