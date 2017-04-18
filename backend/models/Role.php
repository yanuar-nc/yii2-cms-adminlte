<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property RolesMenus[] $rolesMenuses
 */
class Role extends \common\models\BaseModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'created_at', 'updated_at'], 'integer'],
            [['code'], 'number'],
            [['name'], 'string', 'max' => 100],
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
            'code' => [ 'textInput' => [ 'options' => ['type' => 'number'] ] ],
            'name',
            'row_status' => [
                'dropDownList' => [ 'list' => [ 1 => 'Active', 0 => 'Disactive' ] ]
            ]
        ];
    }

    
    /**
     * the Header for data table.
     *
     * @return     array  The header.
     */
    public static function getHeader()
    {
        return [
            'Id',
            'Code',
            'Name',
            'Status',
            'Action'
        ];
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
            ->andWhere(['LIKE', 'name', $params['sSearch']])
            ->orderBy( 'id DESC' );
        $countQuery = clone $query;

        $query = $query->offset($params['iDisplayStart'])
                       ->limit($params['iDisplayLength']);

        $result[ 'aEcho' ] = $params['sEcho'];
        $result[ 'total' ] = $countQuery->count();
        $result[ 'iTotalRecords' ] = $countQuery->count();
        $result[ 'iTotalDisplayRecords' ] = $countQuery->count();

        $data = [];
        
        foreach ($query->all() as $model) {

            $action = \backend\components\View::groupButton( [
                'Set Permission' => ['role/set-permission', 'id' => $model->id], 
                'separator' => true,
                'Update' => ['role/create', 'id' => $model->id], 
                'Delete' => ['role/delete', 'id' => $model->id] ] );

            $data[] = [
                $model->id,
                $model->code,
                $model->name,
                $model->getStatus(),
                $action                
            ];
            

        }
        $result[ 'aaData' ] = $data;
        return json_encode($result);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleMenu()
    {
        return $this->hasMany(RoleMenu::className(), ['role_id' => 'id']);
    }
}
