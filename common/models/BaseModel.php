<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class BaseModel extends ActiveRecord
{


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

}