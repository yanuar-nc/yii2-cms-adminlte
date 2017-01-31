<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\Page;
use backend\components\Upload;
/**
 * Menu controller
 */
class PageController extends BaseController
{

    public $title = 'Page';
    public $description = 'Manage yourpage on this page';

    public function actionIndex()
    {
    	return $this->render('index.twig', [ 'lists' => Page::find()->with('user')->all() ] );
    }

    public function actionCreate()
    {
        $model = new Page();

        if ( Yii::$app->request->post() )
        {
            $post = Yii::$app->request->post();
            $post['Page']['user_id'] = $this->user->id;
            $saveModel = Page::saveData($model, $post);
            if ( $saveModel[ 'status' ] == true )
            {
                
                // Upload::save($model);

                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['page/index']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Page::formData() ] );
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

        $model = Page::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\NotFoundHttpException();

        if ( Yii::$app->request->post() )
        {

            $saveModel = Page::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['page/index']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Page::formData() ] );
    }

    public function actionDelete()
    {

    }
    
    public function actionListOfData()
    {
    	return Page::getDataForAjax(Yii::$app->request->get());
    }

}