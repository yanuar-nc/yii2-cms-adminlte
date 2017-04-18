<?php

use yii\db\Migration;

/**
 * Handles the creation of table `role_menu`.
 */
class m170416_042917_create_role_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('role_menu', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull(),
            'menu_id' => $this->integer()->notNull(),
            'action_id' => $this->integer()->notNull(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');


        // indexing for role_id
        $this->createIndex(
            'idx-role_id',
            'role_menu',
            'role_id'
        );

        // add foreign key for table `role`
        $this->addForeignKey(
            'fk-role-role_id',
            'role_menu',
            'role_id',
            'role',
            'id',
            'CASCADE'
        );


        // indexing for menu_id
        $this->createIndex(
            'idx-menu_id',
            'role_menu',
            'menu_id'
        );

        // add foreign key for table `menu`
        $this->addForeignKey(
            'fk-role-menu_id',
            'role_menu',
            'menu_id',
            'menu',
            'id',
            'CASCADE'
        );


        // indexing for action_id
        $this->createIndex(
            'idx-action_id',
            'role_menu',
            'action_id'
        );

        // add foreign key for table `action`
        $this->addForeignKey(
            'fk-role-action_id',
            'role_menu',
            'action_id',
            'action',
            'id',
            'CASCADE'
        );


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('role_menu');
    }
}
