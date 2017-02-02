<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\RoleMenu;
use backend\components\Upload;
/**
 * Menu controller
 */
class RoleMenuController extends BaseController
{

    public $title = 'Role Menu In Allowed';
    public $menu  = 'role';
    public $menuChild  = 'menu-allowed';
    public $description = 'Manage your role menu on this page';
    
    public function actionIndex()
    {
    	return $this->render('index.twig', [ 'lists' => RoleMenu::lists()->joinWith(['role','menu'])->all() ] );
    }

    public function actionCreate($id = null)
    {
        if ($id == null){

            $model = new RoleMenu();

        } else {

            $model = RoleMenu::findOne($id);
            if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        }

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = RoleMenu::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect([ Yii::$app->controller->id . '/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => RoleMenu::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = RoleMenu::deleteData(new RoleMenu(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect([ Yii::$app->controller->id . '/index']);
    }

}