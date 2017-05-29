<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message_reply`.
 */
class m170517_111633_create_message_reply_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('message_reply', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer()->notNull(),
            'email_sender' => $this->string(125)->notNull(),
            'body' => $this->text()->notNull(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null()
        ], 'ENGINE InnoDB');

        // indexing for message_id
        $this->createIndex(
            'idx-message_id',
            'message_reply',
            'message_id'
        );

        // add foreign key for table `message`
        $this->addForeignKey(
            'fk-message-message_id',
            'message_reply',
            'message_id',
            'message',
            'id',
            'CASCADE'
        );

        $this->insert('message_reply', [
            'message_id' => 1,
            'email_sender' => 'noreply@snowflake.loc',
            'body' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout',
            'created_by' => 1,
            'created_at' => strtotime('now')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('message_reply');
    }
}
