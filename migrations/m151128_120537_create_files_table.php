<?php

use yii\db\Schema;
use yii\db\Migration;

class m151128_120537_create_files_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('files', [
            'id'           => Schema::TYPE_PK,
            'name'         => Schema::TYPE_STRING . '(128) NOT NULL',
            'extension'    => Schema::TYPE_STRING . '(16) NOT NULL',
            'mime_type'    => Schema::TYPE_STRING . '(128) NOT NULL',
            'size'         => Schema::TYPE_INTEGER . ' NOT NULL',
            'real_name'    => Schema::TYPE_STRING . '(32) NOT NULL',
            'path'         => Schema::TYPE_STRING . '(32) NOT NULL DEFAULT ""',
            'created'      => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated'      => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'is_protected' => Schema::TYPE_BOOLEAN . ' NOT NULL',
        ]);

        $this->addColumn('articles', 'logo_image_file_id', Schema::TYPE_INTEGER . ' DEFAULT NULL');
        $this->addForeignKey('article_logo_image', 'articles', 'logo_image_file_id', 'files', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('article_logo_image', 'articles');
        $this->dropColumn('articles', 'logo_image_file_id');
        $this->dropTable('files');
    }
}

