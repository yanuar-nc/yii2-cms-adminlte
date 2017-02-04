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

    public static $uploadFile = [
        'image' => [
            'path' => 'page/',
            'resize' => [
                [
                    'prefix' => 'thumb_',
                    'size' => [200,200],
                ]
            ]
        ]
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'subcontent', 'content', 'user_id', ], 'required'],
            [['title'], 'alphabetsValidation'],
            [['subcontent', 'content'], 'string'],
            [['user_id', 'row_status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 200],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024*1024, 'tooBig' => 'The "{file}" {attribute} is too big. Its size cannot exceed 1MB'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'title' => [
                'textInput' => [ 'options' => ['placeholder' => 'Title'] ] 
            ],
            'subcontent' => [
                'textInput' => [ 'options' => ['placeholder' => 'Subcontent', 'ha' => 'ss'] ] 
            ],
            'content' => [
                'textarea' => [ 'options' => ['class' => 'wysihtml'] ]
            ],
            'image' => [
                'fileInput'
            ],
            'row_status' => [
                // 'radioList' => [ 'list' => [ 0 => 'Active', 1 => 'Disactive' ] ]
                'dropDownList' => [ 'list' => [ 1 => 'Active', 0 => 'Disactive' ] ]
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
            'title' => 'Title',
            'subcontent' => 'Subcontent',
            'content' => 'Content',
            'user_id' => 'User ID',
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
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function listData()
    {
        return static::lists()->all();
    }
}
