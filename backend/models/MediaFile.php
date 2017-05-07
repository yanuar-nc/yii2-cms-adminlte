<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "media_file".
 *
 * @property integer $id
 * @property integer $media_folder_id
 * @property string $title
 * @property string $description
 * @property string $name
 * @property string $file_type
 * @property integer $size
 * @property integer $row_status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property MediaFolder $mediaFolder
 */ 
class MediaFile extends \common\models\BaseModel
{

     public $base64Thumb;
     
     public static $uploadFile = [
        'name' => [
            'using'  => 'manually',
            'path'   => 'uploader/page/',
            'resize' => [
                [
                    'prefix' => 'thumb_',
                    'size' => [200,200],
                ],
                [
                    'prefix' => 'normal_',
                    'size' => [500,500],
                ],

            ]
        ]
    ];

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
            [['media_folder_id', 'size', 'row_status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['title', 'media_folder_id', 'name', 'file_type'], 'required'],
            [['description'], 'string'],
            ['title', 'alphabetsValidation'],
            [['title', 'name'], 'string', 'max' => 100],
            [['file_type'], 'string', 'max' => 30],
            [['media_folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => MediaFolder::className(), 'targetAttribute' => ['media_folder_id' => 'id']],
        ]; 
    }

    /*public function beforeSave( $insert )
    {

         if (parent::beforeSave($insert)) {

            static::$uploadFile['name']['path'] = 

            return true;
         }
         return false;
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_folder_id' => 'Folder',
            'name' => 'File',
            'file_type' => 'File Type',
            'size' => 'Size',
            'row_status' => 'Row Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolder()
    {
        return $this->hasOne(MediaFolder::className(), ['id' => 'media_folder_id'])
            ->andWhere(['=', 'media_folder.row_status', 1]);
    }

    public static function getData()
    {
        return static::fetch()->innerJoinWith('folder');
    }
}
