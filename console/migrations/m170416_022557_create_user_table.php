<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170416_022557_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string(100)->notNull(),
            'position' => $this->string(100),
            'image' => $this->string(150),
            'email' => $this->string(150)->notNull(),
            'username'   => $this->string(50)->notNull(),
            'password'   => $this->string(200)->notNull(),
            'password_reset_token' => $this->string(200),
            'auth_key'   => $this->string(200),
            'role'       => $this->integer()->notNull(),
            'last_login' => $this->integer(11),
            'user_agent' => $this->string(250),
            'row_status' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
