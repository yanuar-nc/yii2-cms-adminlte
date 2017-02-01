<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
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
            [['name', 'link', 'code'], 'required'],
            [['parent_id', 'created_at', 'row_status', 'updated_at'], 'integer'],
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
            'code' => 'Code',
            'name' => 'Name',
            'icon' => 'Icon',
            'link' => 'Link',
            'parent_id' => 'Parent ID',
            'row_status' => 'Status',
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
            'code',
            'name',
            'icon',
            'link',
            'parent_id' => [
                'dropDownList' => [ 'list' => static::getParent() ]
            ],
            'row_status' => [
                // 'radioList' => [ 'list' => [ 0 => 'Active', 1 => 'Disactive' ] ]
                'dropDownList' => [ 'list' => [ 1 => 'Active', 0 => 'Disactive' ] ]
            ]
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
            ->where( ['row_status' => static::STATUS_ACTIVE] )
            ->joinWith( [ 'role_menu' => function( $query ) use ( $roleId ) {
                $query->where( [ 'roles_menus.role_id' => $roleId ] );
            }] )
            ->orderBy('position ASC')
            ->all();
    }

    public static function getMenuAdmin()
    {
        return static::find()
            ->where( ['row_status' => static::STATUS_ACTIVE] )
            ->orderBy('position ASC')
            ->all();
    }

    public static function getParent()
    {
        $query = static::find()->select('id,name')->asArray()->all();
        $list  = ArrayHelper::map($query, 'id', 'name');
        $result = [ null => '-- No Parent --' ] + $list;
        return $result;
    }

    /**
     * getDataForAjax 
     * Function ini untuk menampilkan data dalam bentuk json
     * yang akan dirender kedalam AJAX
     * 
     * @param  [array] $params (Variable ini diberikan oleh DataTable)
     * @return json
     */
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
        
        ///Check permission di Object Access Rule///
        $access = AccessRule::actionAccess(['update','delete'], Yii::$app->user->identity->role);

        foreach ($query->all() as $model) {

            $action = null;
            
            if ( $access['update'] == true ) {
                $action .= '<a href="'.Url::to(['menu/create', 'id' => $model->id]).'"><i class="fa fa-edit"></i> Update</a> &nbsp; ';
            } 

            if ( $access[ 'delete' ] == true ) {
                $action .= '<a href="'.Url::to(['menu/delete', 'id' => $model->id]).'"><i class="fa fa-times"></i> Delete</a>';
            }
        
            $data[] = [
                $model->id,
                "<h4>" . $model->name . "</h4><small>Icon: &nbsp; <i class='" .$model->icon."'></i> " . $model->icon . " </small>",
                $model->code,
                '<a href="'.Url::to([$model->link]).'">' . $model->link . '</a>',
                static::$getStatus[$model->row_status],
                $action                
            ];
            

        }
        $result[ 'aaData' ] = $data;
        return json_encode($result);
    }
}
