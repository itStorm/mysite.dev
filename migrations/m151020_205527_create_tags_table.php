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
            'article_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id'     => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addForeignKey('article_tag_article_id', 'article_tag', 'article_id', 'articles', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('article_tag_tag_id', 'article_tag', 'tag_id', 'tags', 'id', 'RESTRICT', 'CASCADE');
        $this->createIndex('article_tag_article_id_tag_id', 'article_tag', ['article_id', 'tag_id'], true);
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
