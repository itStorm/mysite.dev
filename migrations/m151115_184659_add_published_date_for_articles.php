<?php

use yii\db\Schema;
use yii\db\Migration;

class m151115_184659_add_published_date_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'published_date', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
        $this->db->createCommand('UPDATE articles SET published_date = created')->execute();
    }

    public function down()
    {
        $this->dropColumn('articles', 'published_date');
    }
}
