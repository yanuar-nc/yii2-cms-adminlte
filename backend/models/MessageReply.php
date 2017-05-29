<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "message_reply".
 *
 * @property integer $id
 * @property integer $message_id
 * @property string $email_sender
 * @property string $body
 * @property integer $row_status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property Message $message
 */
class MessageReply extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'email_sender', 'body'], 'required'],
            [['message_id', 'row_status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['body'], 'string'],
            [['email_sender'], 'string', 'max' => 125],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['message_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => 'Message ID',
            'email_sender' => 'Email Sender',
            'body' => 'Body',
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
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
