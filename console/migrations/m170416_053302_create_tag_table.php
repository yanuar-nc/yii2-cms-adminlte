<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m170416_053302_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
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
        $this->dropTable('tag');
    }
}
