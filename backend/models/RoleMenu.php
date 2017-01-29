<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "roles_menus".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $menu_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Menus $menu
 * @property Roles $role
 */
class RoleMenu extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles_menus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'menu_id', 'created_at', 'updated_at'], 'required'],
            [['role_id', 'menu_id', 'created_at', 'updated_at'], 'integer'],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menus::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'menu_id' => 'Menu ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id'])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id'])->one();
    }

}
