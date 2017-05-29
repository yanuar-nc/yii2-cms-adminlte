<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m170517_105332_create_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'email' => $this->string(100)->notNull(),
            'subject' => $this->string(125)->notNull(),
            'body' => $this->text()->notNull(),
            'read_status' => $this->integer()->notNull()->defaultValue(0),
            'reply_status' => $this->integer()->notNull()->defaultValue(0),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');

        $this->addCommentOnColumn('message', 'read_status', '0 = Not read; 1 = Already read');
        $this->addCommentOnColumn('message', 'reply_status', '0 = Not reply; 1 = Already reply');

        \Yii::$app->db->createCommand()->batchInsert('message', 
            ['name', 'email', 'subject', 'body', 'read_status', 'reply_status'], 
            [
                [ 'Anonymous', 
                  'mail@anonymous.com', 
                  'This is my subject', 
                  'I wanna complain to this admin',
                  1,
                  1
                ],
                [ 'Mr. Lorem', 
                  'mail@loremipsum.com', 
                  'Lorem ipsum dolor sit amet', 
                  'Excepteur sint occaecat cupidatat non proident, sunt in ulpa qui officia deserunt mollit anim id est laborum',
                  0,
                  0
                ],
            ])->execute();

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('message');
    }
}
