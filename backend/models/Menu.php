<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use backend\components\AccessRule;

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
    public function getrole_menu()
    {
        return $this->hasMany(RoleMenu::className(), ['menu_id' => 'id']);
    }

    /**
     * [getMenuPermission description]
     * @param  [integer] $roleId [description]
     * @return ojbect
     */
    public static function getMenuPermission($roleId)
    {
        return static::find()
            ->joinWith( [ 'role_menu' => function($query) use ($roleId) {
                $query->where(['roles_menus.role_id' => $roleId]);
            }] )
            ->all();
    }

    public static function getDataForAjax($params)
    {
        $query = static::find()
            ->offset($params['iDisplayStart'])
            ->limit($params['iDisplayLength'])
            ->orderBy( 'id DESC' );

        $result[ 'aEcho' ] = $params['sEcho'];
        $result[ 'total' ] = $query->count();
        $result[ 'iTotalRecords' ] = $query->count();
        $result[ 'iTotalDisplayRecords' ] = $query->count();

        $data = [];
        
        $access = AccessRule::actionAccess(['update','delete'], Yii::$app->user->identity->role);

        foreach ($query->all() as $model) {

            $action = null;
            
            if ( $access['update'] == true ) {
                $action .= '<a href="'.Url::to(['menu/update', 'id' => $model->id]).'"><i class="fa fa-edit"></i> Update</a> &nbsp; ';
            } 
            
            if ( $access[ 'delete' ] == true ) {
                $action .= '<a href="'.Url::to(['menu/delete', 'id' => $model->id]).'"><i class="fa fa-times"></i> Delete</a>';
            }
        
            $data[] = [
                $model->id,
                $model->name,
                '<i class="'.$model->icon.'"></i> ' . $model->icon,
                '<a href="'.Url::to([$model->link]).'">' . $model->link . '</a>',
                date('d/M/Y', $model->created_at),
                $action                
            ];
            

        }
        $result[ 'aaData' ] = $data;
        return json_encode($result);
    }
}
