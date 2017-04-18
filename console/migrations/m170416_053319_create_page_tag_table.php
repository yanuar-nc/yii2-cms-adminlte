<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page_tag`.
 */
class m170416_053319_create_page_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('page_tag', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');

        // indexing for page_id
        $this->createIndex(
            'idx-page_id',
            'page_tag',
            'page_id'
        );

        // add foreign key for table `page`
        $this->addForeignKey(
            'fk-page-page_id',
            'page_tag',
            'page_id',
            'page',
            'id',
            'CASCADE'
        );

        // indexing for tag_id
        $this->createIndex(
            'idx-tag_id',
            'page_tag',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-tag-tag_id',
            'page_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('page_tag');
    }
}
