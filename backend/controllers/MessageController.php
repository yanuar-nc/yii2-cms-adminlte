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
    public $menu  = 'message';
    public $code  = 'message';
    public $description = 'Message of users.';
    
    public function actionIndex()
    {
    	return $this->render('/templates/ajax-list', [ 'headers' => Message::getHeader(), 'disabledInsertNewItem' => true ]);
    }


    public function actionReply($id)
    {
        $model = new MessageReply();
        $request = Yii::$app->request;
        if ( $request->isPost )
        {
            exit;
        }
        $message = Message::fetch()->andWhere(['id' => $id])->with(['messageReplies' => function($query) {
                $query->with('user');   
            }
        ])->one();

        return $this->render('reply', compact('model', 'message'));
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