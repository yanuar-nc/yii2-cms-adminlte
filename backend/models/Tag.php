<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $row_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PageTag[] $pageTags
 */
class Tag extends \common\models\BaseModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'row_status'], 'required'],
            [['id', 'row_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'row_status' => 'Row Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
        
        ///Check permission di Object Access Rule///
        foreach ($query->all() as $model) {

            $action = \backend\components\View::groupButton( [
                'Update' => ['tag/update', 'id' => $model->id],
                'Delete' => ['tag/delete', 'id' => $model->id] ] );
            

            $data[] = [
                $model->id,
                $model->name,
                $model->getStatus(),
                $action                
            ];
            

        }
        $result[ 'aaData' ] = $data;
        return json_encode($result);
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
            'name',
            'row_status' => [
                'dropDownList' => [ 'list' => static::$getStatus ]
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageTags()
    {
        return $this->hasMany(PageTag::className(), ['tag_id' => 'id']);
    }
}
