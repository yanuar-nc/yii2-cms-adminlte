<?php
namespace backend\controllers;

use Yii;
use backend\models\Tag;
/**
 * Menu controller
 */
class TagController extends BaseController
{

    public $code  = 'tag';
    
    public $title = 'Tag';
    public $parentMenu  = 'page';
    public $subMenu  = 'tag';
    public $description = 'Manage your tag on this page';
    
    public function actionIndex()
    {
    	return $this->render('/templates/ajax-list', [ 'headers' => Tag::getHeader(), 'disabledInsertNewItem' => true ]);
    }

    public function actionCreate($id = null)
    {
        if ($id == null){

            $model = new Tag();

        } else {

            $model = Tag::findOne($id);
            if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        }

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = Tag::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['tag/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form', [ 'model' => $model, 'fields' => Tag::formData() ] );
    }

    /**
     * { function_description }
     *
     * @param      <int>                          $id     The identifier
     *
     * @throws     \yii\web\NotFoundHttpException  (Jika tidak ada satupun data yang ditemukan,
     *                                              maka akan dilempar ke halaman not found)
     *
     */
    public function actionUpdate($id)
    {

        $model = Tag::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = Tag::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['tag/index']);
            }
        }
        return $this->render( '/templates/form', [ 'model' => $model, 'fields' => Tag::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = Tag::deleteData(new Tag(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['tag/index']);
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
        return Tag::getDataForAjax(Yii::$app->request->get());
    }
}