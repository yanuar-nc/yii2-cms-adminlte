<?php

use yii\db\Migration;

/**
 * Handles adding title to table `media_file`.
 */
class m170915_072149_add_title_column_to_media_file_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('media_file', 'title', $this->string(100));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('media_file', 'title');
    }
}
