<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            [['role_id', 'menu_id'], 'required'],
            [['role_id', 'menu_id', 'created_at', 'updated_at'], 'integer'],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
            // [['row_status'], 'default', 1]
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
            'row_status' => 'Row Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
            'role_id' => [
                'dropDownList' => [ 'list' => static::getListRole() ]
            ],
            'menu_id' => [
                'dropDownList' => [ 'list' => static::getListMenu() ]
            ],
            'row_status' => [
                'dropDownList' => [ 'list' => [ 1 => 'Active', 0 => 'Disactive' ] ]
            ],
        ];
    }

    public static function getListMenu()
    {
        $query = Menu::find()->select('id,name')->asArray()->all();
        $list  = ArrayHelper::map($query, 'id', 'name');
        $result = [ null => '-- No Parent --' ] + $list;
        return $result;
    }

    public static function getListRole()
    {
        $query = Role::find()->select('id,name')->asArray()->all();
        $list  = ArrayHelper::map($query, 'id', 'name');
        $result = [ null => '-- No Parent --' ] + $list;
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

}
