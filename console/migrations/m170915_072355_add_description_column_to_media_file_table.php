<?php

use yii\db\Migration;

/**
 * Handles adding description to table `media_file`.
 */
class m170915_072355_add_description_column_to_media_file_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('media_file', 'description', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('media_file', 'description');
    }
}
