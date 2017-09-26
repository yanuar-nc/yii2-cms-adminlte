<?php
namespace backend\controllers;

use Yii;
use backend\models\Message;
use backend\models\MessageReply;
use yii\helpers\ArrayHelper;

/**
 * Message controller
 */
class MessageController extends BaseController
{

    public $title = 'Message';
    public $parentMenu  = 'message';
    public $description = 'Message of users.';
    
    public function actionIndex()
    {
    	return $this->render('/templates/ajax-list', [ 'headers' => Message::getHeader(), 'disabledInsertNewItem' => true ]);
    }


    public function actionReply($id)
    {

        $model = new MessageReply();

        $message = Message::fetch()->andWhere(['id' => $id])->with(['messageReplies' => function($query) {
                $query->with('user');   
            }
        ])->one();


        // Jika read statusnya not read maka akan 
        // mengupdate read statusnya menjadi Already Read
        if ( $message->read_status == 0 )
        {
            $data['Message']['read_status'] = 1;
            $updateMessage = Message::saveData( $message, $data );
        }

        $request = Yii::$app->request;
        if ( $request->isPost )
        {
            $post = $request->post();
            $data['MessageReply'] = [
                'body' => $post['MessageReply']['body'],
                'email_sender' => 'noreply@support.com',
                'message_id' => $id
            ];
            
            $saveModel = MessageReply::saveData( $model, $data );
            if ( $saveModel[ 'status' ] == true )
            {   

                // Jika reply statusnya not replied maka akan 
                // mengupdate reply statusnya menjadi Already replied
                if ( $message->reply_status == 0 )
                {
                    $data['Message']['reply_status'] = 1;
                    $updateMessage = Message::saveData( $message, $data );
                }

                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['message/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }

        return $this->render('reply', compact('model', 'message'));
    }

    public function actionDelete($id)
    {

        $model = Message::deleteData(new Message(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', MSG_DATA_UPDATE_FAILED);
        }
        return $this->redirect(['message/index']);
    }

    /**
     * listOfData function adalah sebuah mandatori untuk 
     * membuat data table dengan serverside
     * 
     * @param HTTP Get
     * 
     * @return     json
     */
    public function actionListOfData()
    {
    	return Message::getDataForAjax(Yii::$app->request->get());
    }

}