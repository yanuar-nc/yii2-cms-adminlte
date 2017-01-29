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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $this->view->title = 'Login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {

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

        if ( !empty( $checkUser ) )
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
}
