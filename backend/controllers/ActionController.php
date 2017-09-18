<?php
namespace backend\controllers;

use Yii;
use backend\models\Action;

/**
 * Action controller
 */
class ActionController extends BaseController
{

    public $title       = 'Action';
    public $menu        = 'role';
    public $code        = 'action';
    public $menuChild   = 'action';
    public $description = 'Manage yourpage on this page';
    
    public function actionIndex()
    {
    	return $this->render('/templates/ajax-list', [ 'headers' => Action::getHeader(), 'disabledInsertNewItem' => true ]);
    }

    public function actionCreate()
    {
        $model = new Action();

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = Action::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect([ Yii::$app->controller->id . '/index']);
            }
        }
        return $this->render( '/templates/form', [ 'model' => $model, 'fields' => Action::formData() ] );
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

        $model = Action::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = Action::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect([ Yii::$app->controller->id . '/index']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Action::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = Action::deleteData(new Action(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', MSG_DATA_UPDATE_FAILED);
        }
        return $this->redirect([ Yii::$app->controller->id . '/index']);
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
        return Action::getDataForAjax(Yii::$app->request->get());
    }
}