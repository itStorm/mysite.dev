<?php

use yii\db\Schema;
use yii\db\Migration;

class m151217_220622_seo_params_for_articles extends Migration
{
    public function up()
    {
        $this->addColumn('articles', 'seo_description', Schema::TYPE_STRING . '(1024) DEFAULT ""');
        $this->addColumn('articles', 'seo_keywords', Schema::TYPE_STRING . '(512) DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn('articles', 'seo_description');
        $this->dropColumn('articles', 'seo_keywords');
    }
}
