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

    public $layout = 'main.twig';
    public $session, $userData, $user, $title, $description;

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
                        'actions' => ['login', 'error', 'register'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'list-of-data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_USER,
                            User::ROLE_MODERATOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        // Allow moderators and admins to update
                        'roles' => [
                            User::ROLE_MODERATOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        // Allow admins to delete
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function init()
    {
        $app = Yii::$app;
        
        $this->session = $app->session;
        $this->user = $app->user;
        
        if ( !empty($this->user->identity) )
        {
            
            $this->userData = $user = $this->user->identity;
            
            $menu = new MenuComponent($user);
            $view = $this->view;

            ///Set parameter towards view///
            $view->params['user'] = [ 
                'id' => $user['id'], 
                'fullname' => $user['fullname'], 
                'image' => 'img/avatar5.png',
                'position' => $user['position'],
                'role' => User::ROLE[ $user['role'] ],
                'created_at' => date('d F Y', $user['created_at'] )
            ];
            $view->params['title']       = $this->title;
            $view->params['description'] = $this->description;
            $view->params['userAction']  = AccessRule::getActions( $user['role'] );
            $view->params['menus']       = $menu->getMenu();
        }

    }
}