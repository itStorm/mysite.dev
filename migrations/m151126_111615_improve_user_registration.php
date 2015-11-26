<?php

use yii\db\Schema;
use yii\db\Migration;

class m151126_111615_improve_user_registration extends Migration
{
    public function up()
    {
        $this->addColumn('users', 'created', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
        $this->addColumn('users', 'updated', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
        $this->db->createCommand('UPDATE users SET created = 1447707600, updated = 1447707600')->execute();

        $this->addColumn('users', 'is_deleted', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE');
        $this->addColumn('users', 'is_enabled', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE');
        $this->db->createCommand('UPDATE users SET is_enabled = TRUE')->execute();

        $this->addColumn('users', 'email_confirm', Schema::TYPE_STRING . '(32) NOT NULL DEFAULT \'\'');
    }

    public function down()
    {
        $this->dropColumn('users', 'created');
        $this->dropColumn('users', 'updated');
        $this->dropColumn('users', 'is_deleted');
        $this->dropColumn('users', 'is_enabled');
        $this->dropColumn('users', 'email_confirm');
    }
}
