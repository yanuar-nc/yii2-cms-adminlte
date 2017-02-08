<?php
 
namespace backend\components;
 
use Yii;
use Yii\helpers\ArrayHelper;
use backend\models\Action;
use backend\models\RoleMenu;
use backend\models\Role;
use backend\models\User;

class AccessRule extends \yii\filters\AccessRule {
 
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {

        if (empty($this->roles)) {
            return true;
        }

        foreach ($this->roles as $role) {

            if ($role === '?') {
                
                if ($user->getIsGuest()) {
                    return true;
                }

            } elseif ($role === '@') {

                if (!$user->getIsGuest()) {

                    if ( $user->identity->role != User::ROLE_ADMIN )
                    {
                        $action = Yii::$app->controller->action->id;
                        
                        $role   = Role::find()
                            ->where(['=', 'code', $user->identity->role])->one();
                        $roleId = $role->id;

                        $controllerCode   = Yii::$app->controller->code;
                        $controllerAction = Yii::$app->controller->action->id;
                        $roleMenu = RoleMenu::find()
                            ->joinWith('menu',    'menu.id    = roles_menus.menu_id')
                            ->joinWith('action', 'action.id = roles_menus.action_id')
                            ->where(['=', 'menus.code', $controllerCode])
                            ->andWhere(['=', 'actions.name', $controllerAction])
                            ->one();

                        if ( empty( $roleMenu ) )
                        {
                            return false;
                        }
                        
                    }
                    return true;

                }
            // Check if the user is logged in, and the roles match
            } elseif (!$user->getIsGuest() && $role === $user->identity->role) {
                return true;
            }
        }
 
        return false;
    }

    /**
     * [getActions]
     * Untuk mendapatkan action apa saja yang bisa digunakan.
     * Biasanya return dari function ini untuk menentukan tombol apa 
     * saja yang diaktifkan. Seperti di halaman index pada module
     * 
     * @param  [integer] $roleCode [roleCode berdasarkan user role yang sedang digunakan]
     * @return [array]
     */
    public static function getActions( $roleCode )
    {
        switch ( $roleCode ) {
            case User::ROLE_ADMIN:
                return [ 'create', 'update', 'delete', 'index' ];
            break;
            case User::ROLE_MODERATOR:
                return [ 'create', 'update', 'index' ];
            break;
            case User::ROLE_USER:
                return [ 'index' ];
            break;
            
            default:
                return [ 'index' ];
            break;
        }
    }

    public static function actionAccess( $actions, $roleCode )
    {

        $getActions = static::getActions( $roleCode );
        
        $result = [];
        foreach( $actions as $action )
        {
            if ( in_array( $action, $getActions ) )
            {
                $result[$action] = true;
            }
        }
        return $result;
    }

}