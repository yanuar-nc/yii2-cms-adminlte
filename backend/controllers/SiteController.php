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


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
         $this->layout = 'main.twig';
        return $this->render('index.twig');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $this->view->title = 'Login';
        $this->view->params['breadcrumbs'][] = $this->view->title;

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
        $this->layout = 'login.twig';

        $model = new User();
        if ( $model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post('User');
            $model->username = $post['username'];
            $model->password = $post['password'];
            $model->signup();
        }
        return $this->render('register.twig', [ 'model' => $model ] );
    }
}
