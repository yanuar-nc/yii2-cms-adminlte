<?php
 
namespace backend\components;
 
use Yii;
use Yii\helpers\ArrayHelper;
use backend\models\Action;
use backend\models\RoleMenu;
use backend\models\Role;
use backend\models\User;

class AccessRule extends \yii\filters\AccessRule 
{

    /**
     * Match Role Function
     * Fungsi ini untuk memberikan akses pada setiap menu
     * berdasarkan ROLE user
     * 
     * @param  user      Session Login User
     * 
     * @throws    ForbiddenException 
     * 
     * @return true|false (allow|forbidden)
     * 
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

                    /**
                     * Check role user, bila bukan admin maka
                     * akan difilter aksesnya.
                     * Dan admin/role(30) bebas akses apa aja.
                     */
                    if ( $user->identity->role != User::ROLE_ADMIN )
                    {
                        $app = Yii::$app;

                        $controllerId       = $app->controller->id;
                        $controllerCode     = $app->controller->code;
                        $controllerAction   = $app->controller->action->id;

                        $roles = static::getRoleAcesses( $user->identity->role  );

                        array_push( $roles[ $controllerId ], 'list-of-data' );

                        if ( !in_array( $controllerAction, $roles[ $controllerId ] ) )
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

    public static function getRoleAcesses( $roleCode )
    {
        $roles = Yii::$app->params[ 'roleAccesses' ][ $roleCode  ];

        // All user have these access
        $roles = ArrayHelper::merge( [ 
            'media-uploader' => [ 
                'ajax-get-files', 
                'ajax-get-folders',
                'ajax-upload-file'
            ],
            'site' => [ 'index' ],
            'user' => [ 'change-password' ],
        ], $roles );

        return $roles;

    }

}