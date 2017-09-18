<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170416_023308_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull(),
            'name' => $this->string(80)->notNull(),
            'icon' => $this->string(30)->null()->defaultValue('fa fa-circle-o'),
            'link' => $this->string(100)->notNull(),
            'parent_id' => $this->integer(),
            'position' => $this->integer()->notNull()->defaultValue(99),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),

        ], 'ENGINE InnoDB');

        $this->insert('menu', [
            'id' => 1,
            'code' => 'dashboard',
            'name' => 'Dashboard',
            'icon' => 'fa fa-dashboard',
            'link' => 'site/index',
            'parent_id' => null,
            'position' => 1
        ]);

        $this->insert('menu', [
            'id' => 2,
            'code' => 'menu',
            'name' => 'Menu Configuration',
            'icon' => 'fa fa-navicon',
            'link' => 'menu/index',
            'parent_id' => null,
            'position' => 11
        ]);
        $this->insert('menu', [
            'id' => 3,
            'code' => 'role',
            'name' => 'User Access',
            'icon' => 'fa fa-user',
            'link' => 'roles/index',
            'parent_id' => null,
            'position' => 6
        ]);
        $this->insert('menu', [
            'id' => 4,
            'code' => 'pages',
            'name' => 'Pages',
            'icon' => 'fa fa-tv',
            'link' => 'page/index',
            'parent_id' => null,
            'position' => 6
        ]);
        $this->insert('menu', [
            'id' => 5,
            'code' => 'menu-allowed',
            'name' => 'Menu Allowed',
            'icon' => '',
            'link' => 'role-menu/index',
            'parent_id' => 3,
            'position' => 2
        ]);
        $this->insert('menu', [
            'id' => 6,
            'code' => 'role',
            'name' => 'Role',
            'icon' => '',
            'link' => 'role/index',
            'parent_id' => 3,
            'position' => 9
        ]);
        $this->insert('menu', [
            'id' => 7,
            'code' => 'user',
            'name' => 'User',
            'icon' => 'fa fa-group',
            'link' => 'user/index',
            'parent_id' => null,
            'position' => 8
        ]);
        $this->insert('menu', [
            'id' => 8,
            'code' => 'action',
            'name' => 'Action',
            'icon' => '',
            'link' => 'action/index',
            'parent_id' => 3,
            'position' => 7
        ]);
        $this->insert('menu', [
            'id' => 9,
            'code' => 'tag',
            'name' => 'Tags',
            'icon' => 'fa fa-tag',
            'link' => 'tag/index',
            'parent_id' => null,
            'position' => 10
        ]);
        $this->insert('menu', [
            'id' => 12,
            'code' => 'media-uploader',
            'name' => 'Media Uploader',
            'icon' => 'fa fa-file-photo-o',
            'link' => 'media-uploader/index',
            'parent_id' => null,
            'position' => 12
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
