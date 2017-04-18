<?php

use yii\db\Migration;

/**
 * Handles the creation of table `media_file`.
 */
class m170416_052827_create_media_file_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('media_file', [
            'id' => $this->primaryKey(),
            'media_folder_id' => $this->integer(),
            'name' => $this->string(100)->notNull(),
            'file_type' => $this->string(30)->notNull(),
            'size' => $this->integer(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');

        // indexing for media_folder_id
        $this->createIndex(
            'idx-media_folder_id',
            'media_file',
            'media_folder_id'
        );

        // add foreign key for table `media_folder`
        $this->addForeignKey(
            'fk-media_folder-media_folder_id',
            'media_file',
            'media_folder_id',
            'media_folder',
            'id',
            'CASCADE'
        );
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('media_file');
    }
}
