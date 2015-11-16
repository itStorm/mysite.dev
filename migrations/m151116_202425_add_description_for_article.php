<?php

use yii\db\Schema;
use yii\db\Migration;

class m151116_202425_add_description_for_article extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'description', Schema::TYPE_STRING . '(512) DEFAULT "" AFTER title');
    }

    public function down()
    {
        $this->dropColumn('articles', 'description');
    }
}
