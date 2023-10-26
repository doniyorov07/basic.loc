<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%new_user}}`.
 */
class m231026_043823_create_new_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%user}}');
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
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
        $this->dropTable('{{%user}}');

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(20),
            'username' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(100)->notNull(),
            'status' => $this->boolean()->defaultValue(1),
        ]);
    }
}
