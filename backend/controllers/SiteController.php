<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\LoginForm;
use backend\models\User;
use backend\models\Notification;
use common\models\ResetPassword;
use backend\services\DashboardService;


/**
 * Site controller
 */
class SiteController extends BaseController
{

    public $parentMenu  = 'dashboard';
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

        $this->layout = 'login';
        $this->view->title = 'Login';
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }
        
        
        $model = new LoginForm();

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


    /**
     * Forgot Password
     * 
     * Pseudocode:
     * user <- data user
     * Jika email dari user tak ada 
     *      return "Error message"
     * JIka ada
     *      user <- genereateToken()
     *      user <- save()
     *      user <- sendEmail(link reset password)
     *      
     * @return. void
     */
    public function actionForgotPassword()
    {
        $this->layout = 'login';
        $model = new User();


        if ( Yii::$app->request->isPost ) {

            $model = User::find()
            ->andWhere( 
                [ 
                    'email' => Yii::$app->request->post( 'User' ),
                    'row_status' => 1
                ] 
            )->one();

            if ( empty( $model ) )
            {
                
                $this->session->setFlash('danger', 'Your email is not exist');
                
                return $this->refresh();  

            } else {

                $model->generatePasswordResetToken();
                $model->save();

                Yii::$app->mailer->compose('passwordResetToken-html', [ 'user' => $model ])
                    ->setFrom( 'no-reply@bundakonicare.co.id' )
                    ->setTo( $model->email )
                    ->setSubject( '[Good Day] Admin Reset Password' )
                    ->send();

                $this->session->setFlash( 'success', 'Your request has been sent.' );

                return $this->redirect( [ 'site/login' ] );

            }
        }
        return $this->render('forgot-password', [ 'model' => $model ] );
    }


    /**
     * Reset Password
     * 
     * Pseudocode
     * user <- data user dari token
     * 
     * jika validateUser() berhasil
     *     user <- setNewPassword()
     *
     * @throws     \yii\web\HttpException
     *
     * @return     void
     */
    public function actionResetPassword()
    {

        $request = Yii::$app->request;
        $model = User::findByPasswordResetToken( $request->get( 'token' ) );

        if ( empty( $model ) )
            throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        $model->scenario = 'reset-password';

        if ( $request->isPost )
        {
            $post  = Yii::$app->request->post( 'User' );
            
            $model->newPassword = $post[ 'newPassword' ];
            $model->rePassword  = $post[ 'rePassword' ];
            
            if ( $model->validate() )
            {

                $model->setPassword( $post[ 'rePassword' ] );
                $model->save();

                $this->session->setFlash( 'success', 'Your password has been updated' );

                return $this->redirect( [ 'site/login' ] );
            }

        }

        $this->layout = 'login';

        return $this->render('reset-password', [ 'model' => $model ] );
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
