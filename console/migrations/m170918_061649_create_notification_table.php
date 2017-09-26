<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notification`.
 */
class m170918_061649_create_notification_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'content' => $this->string(100),
            'link' => $this->string(150),
            'read_status' => $this->integer()->null()->defaultValue(0),
            'row_status' => $this->integer()->null()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('notification');
    }
}
