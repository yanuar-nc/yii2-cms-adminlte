<?php

use yii\db\Migration;

/**
 * Handles the creation of table `media_folder`.
 */
class m170416_052647_create_media_folder_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('media_folder', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'directory' => $this->string(50)->notNull(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('media_folder');
    }
}
