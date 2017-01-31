<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\components\AccessRule;

class BaseModel extends ActiveRecord
{

    const STATUS_DELETED = -1;
    const STATUS_DISACTIVE = 0;
    const STATUS_ACTIVE  = 1;

    static $getStatus = [ -1 => 'Deleted', 0 => 'Disactive', 1 => 'Active' ]; 
	
	public function init()
	{

	}

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function alphabetsValidation($attribute)
    {
        if ( !preg_match( '/^[a-zA-Z ]+$/', $this->$attribute ) )
        {
            $this->addError( $attribute, 'This field must be an alphabets' );
            return false;
        }
        return true;
    }

    public function characterValidation($attribute)
    {
        if ( !preg_match( '/^[a-zA-Z_0-9]*$/', $this->$attribute ) )
        {
            $this->addError( $attribute, 'This field must be character, number or underscore' );
            return false;
        }
        return true;
    }


    public function uniquenessValidation( $attribute, $params)
    {
        $countSameEmail = static::find()->where([$attribute => $this->$attribute])->count();
        if ($countSameEmail) {
            $this->addError($attribute, ucfirst($attribute) . ' is already taken.');
        }
    }

    public static function getStatus( $key )
    {
        return static::$getStatus[$key];
    }

}