<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cabinet}}`.
 */
class m231026_065626_create_cabinet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cabinet}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(20),
            'username' => $this->string(),
            'auth_key' => $this->string(),
            'password_hash' => $this->string(),
            'password_reset_token' => $this->string(),
            'status' => $this->tinyInteger()->defaultValue(9),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cabinet}}');
    }
}
