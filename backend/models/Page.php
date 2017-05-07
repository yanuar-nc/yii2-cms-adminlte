<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $title
 * @property string $subcontent
 * @property string $content
 * @property integer $user_id
 * @property string $image
 * @property integer $row_status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Page extends \common\models\BaseModel
{

    public static $pageType = [ 'about-us' => 'About Us', 'bunda-highlight-apps' => 'Bunda Highlight Apps', ];

    // public static $uploadFile = [
    //     'image' => [
    //         'path' => 'page/',
    //         'resize' => [
    //             [
    //                 'prefix' => 'thumb_',
    //                 'size' => [200,200],
    //             ]
    //         ]
    //     ]
    // ];
    // 
    public function behaviors()
    {
        return [
            \EvgenyGavrilov\behavior\ManyToManyBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'subcontent', 'slug', 'image', 'page_type'], 'required'],
            [['title'], 'alphabetsValidation'],
            ['content', 'required', 'enableClientValidation' => false],
            [['content'], 'string'],
            [['image'], 'required', 'on' => 'create'],
            [['row_status'], 'integer'],
            [['title'], 'string', 'max' => 200],
            ['subcontent', 'string', 'max' => 150],
            // [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024*1024, 'tooBig' => 'The "{file}" {attribute} is too big. Its size cannot exceed 1MB'],
        ];
    }

    /**
     * Data fields of the form
     *
     * @return     array  ( description of the return value )
     */
    public static function formData()
    {
        return [
            'id',
            'page_type' => [
                'dropDownList' => [ 'list' => self::$pageType ]
            ],
            'title' => [
                'textInput' => [ 
                    'options' => [
                        'class' => 'form-control autoslug', 
                        'slug-target' => '#page-slug'
                    ],
                ] 
            ],
            'slug',
            'subcontent' => [
                'textInput' => [ 'options' => ['placeholder' => 'Subcontent'] ] 
            ],
            'content' => [
                'textarea' => [ 'options' => ['class' => 'ckeditor'] ]
            ],
            'image' => [
                'mediaUploader'
            ],
            'row_status' => [
                // 'radioList' => [ 'list' => [ 0 => 'Active', 1 => 'Disactive' ] ]
                'dropDownList' => [ 'list' => static::$getStatus ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Titles',
            'slug' => 'Slug',
            'subcontent' => 'Subcontent',
            'content' => 'Content',
            'Related[tag]' => 'Tag',
            'image' => 'Image',
            'row_status' => 'Row Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getTag()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('page_tag', ['page_id' => 'id']);
    }

    public static function listData()
    {
        return static::fetch()->all();
    }
}
