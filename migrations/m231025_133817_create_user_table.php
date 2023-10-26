<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m231025_133817_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(20),
            'username' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(100)->notNull(),
            'status' => $this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
