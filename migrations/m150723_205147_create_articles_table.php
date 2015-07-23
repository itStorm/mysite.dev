<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_205147_create_articles_table extends Migration
{
    public function up()
    {
        $this->createTable('articles', [
            'id'      => Schema::TYPE_PK,
            'title'   => Schema::TYPE_STRING . '(255) DEFAULT ""',
            'content' => Schema::TYPE_TEXT,
            'created' => Schema::TYPE_TIMESTAMP,
            'updated' => Schema::TYPE_TIMESTAMP,
            'user_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('user_id', 'articles', 'user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('articles');
        echo "m150723_205147_create_articles_table cannot be reverted.\n";

        return false;
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
