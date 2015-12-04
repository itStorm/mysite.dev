<?php

use yii\db\Schema;
use yii\db\Migration;

class m151204_165950_delete_logo_filename_from_articles extends Migration
{
    public function up()
    {
        $this->dropColumn('articles', 'logo_filename');
    }

    public function down()
    {
        $this->addColumn('articles', 'logo_filename', Schema::TYPE_STRING . '(64) DEFAULT ""');
    }
}
