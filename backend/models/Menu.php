<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menus".
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property string $link
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RolesMenus[] $rolesMenuses
 */
class Menu extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'link', 'created_at', 'updated_at'], 'required'],
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['icon'], 'string', 'max' => 50],
            [['link'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'link' => 'Link',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolesMenus()
    {
        return $this->hasMany(RolesMenus::className(), ['menu_id' => 'id']);
    }
}
