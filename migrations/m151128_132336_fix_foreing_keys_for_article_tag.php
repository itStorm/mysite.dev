<?php

use yii\db\Schema;
use yii\db\Migration;

class m151128_132336_fix_foreing_keys_for_article_tag extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('article_tag_article_id', 'article_tag');
        $this->addForeignKey('article_tag_article_id', 'article_tag', 'article_id', 'articles', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {

        $this->dropForeignKey('article_tag_article_id', 'article_tag');
        $this->addForeignKey('article_tag_article_id', 'article_tag', 'article_id', 'articles', 'id', 'RESTRICT', 'CASCADE');
    }
}
