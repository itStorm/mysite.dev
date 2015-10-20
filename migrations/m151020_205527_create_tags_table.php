<?php

use yii\db\Schema;
use yii\db\Migration;

class m151020_205527_create_tags_table extends Migration
{
    public function up()
    {
        $this->createTable('tags', [
            'id'      => Schema::TYPE_PK,
            'name'    => Schema::TYPE_STRING . '(255) NOT NULL',
            'is_base' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
        ]);


        $this->createTable('article_tag', [
            'article_id' => Schema::TYPE_INTEGER,
            'tag_id'     => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        $this->dropTable('article_tag');
        $this->dropTable('tags');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
