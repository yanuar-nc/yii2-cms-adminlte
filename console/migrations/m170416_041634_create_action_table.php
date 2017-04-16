<?php

use yii\db\Migration;

/**
 * Handles the creation of table `action`.
 */
class m170416_041634_create_action_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('action', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'row_status' => $this->integer()->notNull()->defaultValue(1),
            'created_by' => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ], 'ENGINE InnoDB');

        \Yii::$app->db->createCommand()->batchInsert('action', ['name'], [
            ['create'],
            ['update'],
            ['delete'],
            ['index'],
            ['list-of-data'],
            ['crop'],
            ['ajax-ckeditor-image'],
            ['ajax-get-files'],
            ['ajax-get-folders'],
        ])->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('action');
    }
}
