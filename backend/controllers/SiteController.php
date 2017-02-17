<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\LoginForm;
use backend\models\User;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    public $code  = 'dashboard';
    public $menu  = 'dashboard';
    public $title = 'Dashboard';
    public $description = 'This page for analyzing content and user activies.';

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index.twig');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login.twig';
        $this->view->title = 'Login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        
        $model = new LoginForm();
        // var_dump(Yii::$app->request->post());exit;
        if ( $model->load( Yii::$app->request->post() ) && $model->login() ) {
            return $this->goBack();
        } else {

            $checkUser = User::find()->one();

            if ( empty( $checkUser ) )
            {
                $this->session->setFlash('info', 'Welcome in register page');
                return $this->redirect( ['site/register'] );            
            }

            return $this->render('login.twig', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRegister()
    {

        $model = new User();
        
        $checkUser = User::find()->one();

        if ( !empty( $checkUser ) && $this->user->getIsGuest() && $this->user->identity['role'] != 30)
        {
            $this->session->setFlash('warning', 'Please contact admin to register');
            return $this->goBack();            
        }
        
        $this->layout = 'login.twig';

        if ( $model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post('User');
            $model->password = $post['password'];

            if ( $post['password'] != $post['rePassword'] )
            {
                $model->addError('rePassword', 'Re-Password does not equal with password');
            } else {
                if ( !empty($model->signup()) )
                {
                    $this->session->setFlash('success', 'You are successfully registered.');
                    return $this->goBack();                    
                }
            }
        }
        return $this->render('register.twig', [ 'model' => $model ] );
    }

    public function actionDelete()
    {}

    public function actionError()
    {        
        $this->layout = 'error.twig';

        $exception = Yii::$app->errorHandler->exception;
        // $text      = Yii::$app->response->statusText;
        return $this->render('error.twig', [
            'exception'  => $exception, 
            // 'statusText' => $text,
        ]);
    }  
}
