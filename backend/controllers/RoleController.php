<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\Role;
use backend\components\Upload;
/**
 * Menu controller
 */
class RoleController extends BaseController
{

    public $title = 'Role';
    public $menu  = 'role';
    public $menuChild  = 'role';
    public $description = 'Manage your role on this page';
    
    public function actionIndex()
    {
    	return $this->render('index.twig', [ 'lists' => Role::lists()->all() ] );
    }

    public function actionCreate($id = null)
    {
        if ($id == null){

            $model = new Role();

        } else {

            $model = Role::findOne($id);
            if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        }

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = Role::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['role/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Role::formData() ] );
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

        $model = Role::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = Role::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['role/index']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Role::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = Role::deleteData(new Role(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['role/index']);
    }

}