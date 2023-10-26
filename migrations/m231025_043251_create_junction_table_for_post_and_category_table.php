<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%post}}`
 * - `{{%category}}`
 */
class m231025_043251_create_junction_table_for_post_and_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_category}}', [
            'post_id' => $this->integer(),
            'category_id' => $this->integer(),
            'PRIMARY KEY(post_id, category_id)',
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-post_category-post_id}}',
            '{{%post_category}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-post_category-post_id}}',
            '{{%post_category}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-post_category-category_id}}',
            '{{%post_category}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-post_category-category_id}}',
            '{{%post_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-post_category-post_id}}',
            '{{%post_category}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-post_category-post_id}}',
            '{{%post_category}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-post_category-category_id}}',
            '{{%post_category}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-post_category-category_id}}',
            '{{%post_category}}'
        );

        $this->dropTable('{{%post_category}}');
    }
}
