<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_205147_create_articles_table extends Migration
{
    public function up()
    {
        $this->createTable('articles', [
            'id'         => Schema::TYPE_PK,
            'title'      => Schema::TYPE_STRING . '(255) DEFAULT ""',
            'content'    => Schema::TYPE_TEXT,
            'created'    => Schema::TYPE_TIMESTAMP,
            'updated'    => Schema::TYPE_TIMESTAMP,
            'created_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->addForeignKey('articles_created_by', 'articles', 'created_by', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('articles_updated_by', 'articles', 'updated_by', 'users', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('articles');
    }
}
