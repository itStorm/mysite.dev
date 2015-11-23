<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_145312_add_logo_filename_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'logo_filename', Schema::TYPE_STRING . '(64) DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn('articles', 'logo_filename');
    }
}
