<?php
namespace backend\controllers;

use Yii;
use backend\models\User;
/**
 * Menu controller
 */
class UserController extends BaseController
{

    public $code  = 'user';
    
    public $title = 'User';
    public $parentMenu  = 'user';
    public $description = 'Manage your user on this page';
    
    public function actionIndex()
    {
        return $this->render('/templates/ajax-list', [ 'headers' => User::getHeader(), 'disabledInsertNewItem' => true ]);
    }

    public function actionCreate()
    {

        $model = new User();

        if ( $model->load(Yii::$app->request->post()) )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = $model->signup();
            if ( $saveModel == true )
            {
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['user/index']);
            } else {
                $this->session->setFlash('danger', MSG_DATA_EDIT_FAILED);
            }
        }
        return $this->render( '/templates/form', [ 'model' => $model, 'fields' => User::formData() ] );
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

        $model = User::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = User::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['user/index']);
            }
        }

        $form = User::formData();
        unset( $form[ 'password' ] );
        
        return $this->render( '/templates/form', [ 'model' => $model, 'fields' => $form ] );
    }

    public function actionDelete($id)
    {

        $model = User::deleteData(new User(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['user/index']);
    }

    public function actionResetPassword($id)
    {
        $model = User::findOne( $id );

        return $this->render( 'reset-password', [ 'model' => $model ] );
    }

    public function actionChangePassword()
    {
        $model = User::findIdentity( $this->user->id );
        $model->scenario = 'change-password';

        $post  = Yii::$app->request->post('User');
        if ( !empty($post) )
        {

            $model->oldPassword = $post['oldPassword'];
            $model->newPassword = $post['newPassword'];
            $model->rePassword  = $post['rePassword'];

            if ( $model->validate() )
            {
                $model->setPassword($model->rePassword);
                $model->save(false);
                $this->session->setFlash('success', 'Your password successfully updated');
            }

        }
        
        return $this->render('change-password', [ 'model' => $model ] );
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
        return User::getDataForAjax(Yii::$app->request->get());
    }
}