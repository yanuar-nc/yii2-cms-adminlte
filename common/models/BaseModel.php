<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\StringHelper;

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
            $this->addError( $attribute, $this->getAttributeLabel($attribute) . ' should be alphabet' );
            return false;
        }
        return true;
    }

    public function characterValidation($attribute)
    {
        if ( !preg_match( '/^[a-zA-Z_0-9]*$/', $this->$attribute ) )
        {
            $this->addError( $attribute, $this->getAttributeLabel($attribute) . ' must be character, number or underscore' );
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

    /**
     * Gets the status.
     *
     * @param      <type>  $key    The key
     *
     * @return     <type>  The status.
     */
    public static function getStatus( $key )
    {
        return static::$getStatus[$key];
    }

    /**
     * Saves a data.
     *
     * @param      <object>  $model  ( The Model )
     * @param      <array>  $datas  ( variable ini biasanya terdapat dari method POST )
     *
     * @return     array 
     * @var status, message
     */
    public static function saveData( $model, $datas )
    {
        $modelName = StringHelper::basename(get_class($model));

        foreach ( $datas[ $modelName ] as $field => $data ) {
            $model->$field = $data;
        }

        if ($model->save())
        {
            return [ 'status' => true, 'message' => 'Success', 'id' => $model->id ];
        } else {
            $errorMessage = null;
            foreach ( $model->getErrors() as $field => $messages ) {
                foreach ( $messages as $message ) {
                    $errorMessage .= $message . PHP_EOL;
                }
            }
            return [ 'status' => false, 'message' => $model->getErrors() ];
        }
    }
}