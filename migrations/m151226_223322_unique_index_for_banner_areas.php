<?php

use yii\db\Schema;
use yii\db\Migration;

class m151226_223322_unique_index_for_banner_areas extends Migration
{
    public function up()
    {
        $this->createIndex('alias', 'banner_areas', 'alias', true);
    }

    public function down()
    {
        $this->dropIndex('alias', 'banner_areas');
    }
}
