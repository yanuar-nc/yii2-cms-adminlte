<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $body
 * @property integer $read_status
 * @property integer $reply_status
 * @property integer $row_status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property MessageReply[] $messageReplies
 */
class Message extends \common\models\BaseModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['read_status', 'reply_status', 'row_status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 100],
            [['subject'], 'string', 'max' => 125],
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
            'email' => 'Email',
            'subject' => 'Subject',
            'body' => 'Body',
            'read_status' => 'Read Status',
            'reply_status' => 'Reply Status',
            'row_status' => 'Row Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageReplies()
    {
        return $this->hasMany(MessageReply::className(), ['message_id' => 'id']);
    }


    public function getReadStatus()
    {

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
            'User',
            'Body',
            'Read Status',
            'Reply Status',
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
            ->andWhere(['LIKE', 'subject', $params['sSearch']])
            ->orderBy( 'id  DESC' );
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
                'View & Reply' => ['message/reply', 'id' => $model->id],
                'separator1' => true, 
                'Replied' => ['message/reply_status', 'id' => $model->id, 'status' => 1], 
                'Un Replied' => ['message/reply_status', 'id' => $model->id, 'status' => 0], 
                'separator2' => true, 
                'Read' => ['message/read_status', 'id' => $model->id, 'status' => 1], 
                'Un Read' => ['message/read_status', 'id' => $model->id, 'status' => 0], 
                'separator3' => true, 
                'Delete' => ['message/delete', 'id' => $model->id] ] );

            $user = "<p>" . $model->name . "</p>";
            $user .= "<small><i class='fa fa-envelope'><i>&nbsp;" . $model->email . '</small>';

            $body = "<b>{$model->subject}</b> - " . \yii\helpers\StringHelper::truncate($model->body, 50, '...');

            $data[] = [
                $model->id,
                $user,
                $body,
                $model->getConfirmStatus($model->read_status),
                $model->getConfirmStatus($model->reply_status),
                $action                
            ];
            

        }
        $result[ 'aaData' ] = $data;
        return json_encode($result);
    }
}
