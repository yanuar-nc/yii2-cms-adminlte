<?php
namespace backend\controllers;

use Yii;
use backend\models\Page;
use yii\helpers\ArrayHelper;

/**
 * Page controller
 */
class PageController extends BaseController
{

    public $title = 'Page';
    public $parentMenu  = 'page';
    public $code  = 'page';
    public $description = 'Manage yourpage on this page';
    
    public function actionIndex()
    {
    	return $this->render('/templates/ajax-list', [ 'headers' => Page::getHeader(), 'disabledInsertNewItem' => true ]);
    }

    public function actionCreate()
    {
        $model = new Page();

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = Page::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['page/index']);
            }
        }
        return $this->render( '/templates/form.php', [ 'model' => $model, 'fields' => Page::formData() ] );
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

        $tag = ArrayHelper::getColumn($model->getTag()->asArray()->all(), 'id');
        $model->Related['tag'] = $tag;

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = Page::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['page/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form.php', [ 'model' => $model, 'fields' => Page::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = Page::deleteData(new Page(), $id, true);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', MSG_DATA_UPDATE_FAILED);
        }
        return $this->redirect(['page/index']);
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
        return Page::getDataForAjax(Yii::$app->request->get());
    }

}