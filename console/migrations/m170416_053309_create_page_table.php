<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m170416_053309_create_page_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'page_type' => $this->string(50)->notNull(),
            'title' => $this->string(140)->notNull(),
            'slug' => $this->string(140)->notNull(),
            'subcontent' => $this->text()->notNull(),
            'content' => $this->text()->notNull(),
            'image' => $this->string(130)->notNull(),
            'image_dir' => $this->string(100)->notNull(),
            'secondary_image' => $this->string(130)->notNull(),
            'secondary_image_dir' => $this->string(100)->notNull(),
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
        $this->dropTable('page');
    }
}
