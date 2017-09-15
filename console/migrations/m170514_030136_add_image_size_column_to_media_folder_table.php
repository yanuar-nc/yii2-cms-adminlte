<?php

use yii\db\Migration;

/**
 * Handles adding image_size to table `media_folder`.
 */
class m170514_030136_add_image_size_column_to_media_folder_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('media_folder', 'medium_width', $this->integer()->notNull()->after('directory'));
        $this->addColumn('media_folder', 'medium_height', $this->integer()->notNull()->after('medium_width'));
        $this->addColumn('media_folder', 'thumbnail_width', $this->integer()->notNull()->after('medium_height'));
        $this->addColumn('media_folder', 'thumbnail_height', $this->integer()->notNull()->after('thumbnail_width'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('media_folder', 'medium_width');
        $this->dropColumn('media_folder', 'medium_height');
        $this->dropColumn('media_folder', 'thumbnail_width');
        $this->dropColumn('media_folder', 'thumbnail_height');
    }
}
