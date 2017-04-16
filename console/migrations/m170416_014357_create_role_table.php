<?php

use yii\db\Migration;

/**
 * Handles the creation of table `role`.
 */
class m170416_014357_create_role_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('role', [
            'id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull(),
            'name' => $this->string(100)->notNull(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');

        $this->insert('role', [
            'code' => 30,
            'name' => 'Admin',
            'row_status' => 1
        ]);

        $this->insert('role', [
            'code' => 20,
            'name' => 'Moderator',
            'row_status' => 1
        ]);

        $this->insert('role', [
            'code' => 10,
            'name' => 'User',
            'row_status' => 1
        ]);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('role');
    }
}
