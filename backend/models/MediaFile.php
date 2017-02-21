<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "media_file".
 *
 * @property integer $id
 * @property integer $media_folder_id
 * @property string $name
 * @property string $extension
 * @property integer $size
 * @property integer $row_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class MediaFile extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_folder_id', 'name', 'extension', 'size'], 'required'],
            [['media_folder_id', 'size', 'row_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['extension'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_folder_id' => 'Media Folder ID',
            'name' => 'Name',
            'extension' => 'Extension',
            'size' => 'Size',
            'row_status' => 'Row Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
