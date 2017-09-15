<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\LoginForm;
use backend\models\User;
use backend\services\DashboardService;


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
        $dasboard = new DashboardService();
        $dashboardData = $dasboard->result();
        $this->view->params['description'] = '<i>Hello ' . $this->user->identity->fullname . " <span id='greeting'></span>. 
            Anyway, your last login on " . date('d F Y H:i A', $this->user->identity->last_login) . 
            ' using ' . $this->user->identity->user_agent . '</i>.';
        return $this->render('index', $dashboardData);
    }
 
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $environtment = dirname(dirname(__DIR__)) . '\\environments\\loc\\*';
        $environtmentDirList = glob($environtment);
        // var_dump($environtmentDirList);exit;
        $this->layout = 'login';
        $this->view->title = 'Login';
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
            // return $this->goHome();
        }
        
        
        $model = new LoginForm();
        // var_dump(Yii::$app->request->post());exit;
        if ( $model->load( Yii::$app->request->post() ) ) 
        {
            if ( $model->login() )
            {
                $model->updateLastLogin();
                return $this->goBack();
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [ 'error' => \yii\widgets\ActiveForm::validate($model) ];
            }

        } else {

            $checkUser = User::find()->one();

            if ( empty( $checkUser ) )
            {
                $this->session->setFlash('info', 'Welcome in register page');
                return $this->redirect( ['site/register'] );            
            }

            return $this->render('login', [
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
        
        $this->layout = 'login';

        if ( $model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post('User');
            $model->password = $post['password'];

            if ( $post['password'] != $post['rePassword'] )
            {
                $model->addError('rePassword', 'Re-Password does not equal with password');
            } else {
                $model->updated_at = strtotime('now');
                if ( !empty($model->signup()) )
                {
                    $this->session->setFlash('success', 'You are successfully registered.');
                    return $this->goBack();                    
                }
            }
        }
        return $this->render('register', [ 'model' => $model ] );
    }

    public function actionError()
    {        
        $this->layout = 'error';

        $exception = Yii::$app->errorHandler->exception;
        // $text      = Yii::$app->response->statusText;
        return $this->render('error', [
            'exception'  => $exception, 
            // 'statusText' => $text,
        ]);
    }  
}
