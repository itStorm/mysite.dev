<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_214730_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id'            => Schema::TYPE_PK,
            'username'      => Schema::TYPE_STRING . '(255) NOT NULL',
            'email'         => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(60) NOT NULL',
            'auth_key'      => Schema::TYPE_STRING . '(32) NULL DEFAULT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
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
