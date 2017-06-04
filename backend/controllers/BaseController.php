<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\User;
use backend\components\AccessRule;
use backend\components\MenuComponent;

/**
 * Site controller
 */
class BaseController extends Controller
{

    public $session, 
           $menu,
           $menuChild,
           $code,
           $controller,
           $userData, 
           $user, 
           $description, 
           $title;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [ User::ROLE_ADMIN ]
                     ],
                    [
                        'actions' => ['login', 'error', 'register', 'logout' ],
                        'allow' => true,
                    ],
                    // [
                    //     'actions' => ['logout'],
                    //     'allow' => true,
                    //     'roles' => ['@'],
                    // ],
                    AccessRule::getRoleActions()
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'logout' => ['post'],
                ],
            ],
        ];
    }



    public function init()
    {

        $app = Yii::$app;
        $this->session = $app->session;
        $this->user = $app->user;

        $view = $this->view;

        /** Check, apakah ada session user atau tidak */
        if ( !empty($this->user->identity) )
        {

            $view->title = $this->title;
            $view->params['title']       = $this->title;
            $view->params['description'] = $this->description;
            $view->params['menuCurrent'] = $this->menu;
            $view->params['menuChildCurrent'] = $this->menuChild;
        }
        $view->params['project'] = $app->params['project'];
                
    }
    
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

    }

}