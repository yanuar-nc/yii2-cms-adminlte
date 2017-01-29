<?php
 
namespace backend\components;
 
 
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
            case 30:
                return [ 'create', 'update', 'delete', 'index' ];
            break;
            case 20:
                return [ 'create', 'update', 'index' ];
            break;
            case 10:
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
            } else {
                $result[$action] = false;
            }
        }
        return $result;
    }
}