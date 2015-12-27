<?php

use yii\db\Schema;
use yii\db\Migration;

class m151222_215701_banners_tables extends Migration
{
    public function up()
    {
        $this->createTable('banner_areas', [
            'id'    => Schema::TYPE_PK,
            'alias' => Schema::TYPE_STRING . '(128) NOT NULL',
            'name'  => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);

        $this->createTable('banners', [
            'id'      => Schema::TYPE_PK,
            'name'    => Schema::TYPE_STRING . '(255) NOT NULL',
            'code'    => Schema::TYPE_TEXT,
            'area_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey('banner_area_id', 'banners', 'area_id', 'banner_areas', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('banners');
        $this->dropTable('banner_areas');
    }
}