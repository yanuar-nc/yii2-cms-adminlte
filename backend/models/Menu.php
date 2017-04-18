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
    public function rules()
    {
        return [
            [['name', 'link', 'code'], 'required'],
            [['parent_id', 'created_at', 'row_status', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['position'], 'default', 'value' => '0'],
            [['icon'], 'string', 'max' => 50],
            [['icon'], 'default', 'value' => 'fa fa-circle-o'],
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
            'position',
            'link',
            'parent_id' => [
                'dropDownList' => [ 'list' => static::dataOptions('id', 'name') ]
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
            ->where( [static::tableName() . '.row_status' => static::STATUS_ACTIVE] )
            ->joinWith( [ 'role_menu' => function( $query ) use ( $roleId ) {
                $query->where( [ 'role_menu.role_id' => $roleId ] );
            }] )
            ->orderBy('position ASC')
            ->all();
    }

    public static function getMenuAdmin()
    {
        return static::find()
            ->where( [static::tableName() . '.row_status' => static::STATUS_ACTIVE] )
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
        $query = static::fetch()
            ->where(['LIKE', 'name', $params['sSearch']])
            ->orderBy( 'position DESC' );
        $countQuery = clone $query;

        $query = $query->offset($params['iDisplayStart'])
                       ->limit($params['iDisplayLength']);

        $result[ 'aEcho' ] = $params['sEcho'];
        $result[ 'total' ] = $countQuery->count();
        $result[ 'iTotalRecords' ] = $countQuery->count();
        $result[ 'iTotalDisplayRecords' ] = $countQuery->count();

        $data = [];
        
        ///Check permission di Object Access Rule///
        foreach ($query->all() as $model) {

            $action = \backend\components\View::updateButton(['menu/create', 'id' => $model->id]);
            $action .= "&nbsp;" . \backend\components\View::deleteButton(['menu/delete', 'id' => $model->id]);
        
            $data[] = [
                $model->position,
                "<h4>" . $model->name . "</h4><small>Icon: &nbsp; <i class='" .$model->icon."'></i> " . $model->icon . " </small>",
                $model->code,
                '<a href="'.Url::to([$model->link]).'">' . $model->link . '</a>',
                $model->getStatus(),
                $action                
            ];
            

        }
        $result[ 'aaData' ] = $data;
        return json_encode($result);
    }
}
