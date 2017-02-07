<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\StringHelper;

use common\components\Upload;

/**
 * Base Model Class
 * This class supposed to used as Main Model in every module either frontend or backend.
 * Cause, Many important function and required by the other models.
 * 
 * @todo if you have a plan to build validation, i recommended you to put the function
 * in here. 
 * 
 * One for All
 * 
 * @author yanuar nurcahyo <yanuarxnurcahyo@gmail.com>
 * @link http://yanuarnc.com
 * @since Januari 2017
 * 
 */
class BaseModel extends ActiveRecord
{

    const STATUS_DELETED = -1;
    const STATUS_DISACTIVE = 0;
    const STATUS_ACTIVE  = 1;

    public $getStatus = [ -1 => 'Deleted', 0 => 'Disactive', 1 => 'Active' ]; 

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

    /**
     * Alphabets Validation
     * Function ini untuk memvalidasikan sebuah teks menjadi alphabet
     * @category a-z, A-Z, (spasi)
     * 
     * @param      <type>   $attribute  The attribute
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function alphabetsValidation($attribute)
    {
        if ( !preg_match( '/^[a-zA-Z ]+$/', $this->$attribute ) )
        {
            $this->addError( $attribute, $this->getAttributeLabel($attribute) . ' should be alphabet' );
            return false;
        }
        return true;
    }

    /**
     * Character Validation
     * Fungsi ini untuk memvalidasikan character - character yang diijinkan
     * @category a-z, A-Z, _(underscore), 0-9
     * 
     * @param  [type] $attribute [description]
     * @return [type]            [description]
     */
    public function characterValidation($attribute)
    {
        if ( !preg_match( '/^[a-zA-Z_0-9]*$/', $this->$attribute ) )
        {
            $this->addError( $attribute, $this->getAttributeLabel($attribute) . ' must be character, number or underscore' );
            return false;
        }
        return true;
    }


    /**
     * born Date Validation
     * Fungsi ini untuk memvalidasikan tanggal lahir tidak boleh hari ini atau esok
     *
     * @param      <type>   $attribute  The attribute
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function bornDateValidation($attribute)
    {
        $date = $this->$attribute;

        if( $date >= date('Y-m-d') )
        {
            $this->addError( $attribute, 'Date must be less than today');
            return false;
        } 
        return true;
    }

    /**
     * Uniqueness Validation
     * Memvalidasikan suatu field menjadi uniq dari baris yang lain
     *
     * @param      <type>  $attribute  The attribute
     * @param      <type>  $params     The parameters
     * 
     * @return  void
     */
    public function uniquenessValidation( $attribute, $params)
    {
        $count = static::find()->where([$attribute => $this->$attribute])->count();
        if ($count) {
            $this->addError($attribute, ucfirst($attribute) . ' is already taken.');
        }
    }

    /**
     * Password Validation
     * Validasi pada password ini untuk karakter - karakter yang lebih sulit
     * Sehingga user harus memasukan angka, simbol dan karakter
     *
     * @param      string   $attribute  The attribute field
     * @param      string   $params     The parameters
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function passwordValidation( $attribute, $params)
    {
        if ( !preg_match( '/((?=.*\d)(?=.*[a-zA-Z])(?=.*[\W]).{6,})/', $this->$attribute ) )
        {
            $this->addError( $attribute, 'Min Password 6 digits long and include at least one numeric, one symbol and one character.' );
            return false;
        }
        return true;
    }

    /**
     * Gets the status.
     * Jika menggunakan function ini harus ada field row_status ditable
     * 
     * @param      <type>  $key    The key
     *
     * @return     <type>  The status.
     */
    public function getStatus()
    {
        $flag = $this->row_status;
        return $this->getStatus[$flag];
    }

    /**
     * Gets the error.
     *
     * @param    mix  $model  The model
     *
     * @return  string  The Error Message.
     */
    public static function getError($model)
    {
        $errorMessage = null;
        foreach ( $model->getErrors() as $field => $messages ) {
            foreach ( $messages as $message ) {
                $errorMessage .= $message . "\n";
            }
        }
        return $errorMessage;
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

        if ( $model->id != null ) {
            $model->updated_by = Yii::$app->user->identity['id'];
        } else {
            $model->created_by = Yii::$app->user->identity['id'];
        }

        if ( isset( $model::$uploadFile ) && count($model::$uploadFile) > 0 )
        {
            foreach( $model::$uploadFile as $field => $attr )
            {
                // $file = UploadedFile::getInstance($model,$field);
            }
        }
        if ($model->save() && $model->validate())
        {
            
            Upload::save($model); // Jika ada model yang disedikan untuk fileupload

            return [ 'status' => true, 'message' => 'Success', 'id' => $model->id ];

        } else {
            $errorMessage = static::getError($model);

            return [ 'status' => false, 'message' => $errorMessage ];
        }
    }

    /**
     * Delete Data
     * Function ini tidak dapat menghapus database
     * hanya mengubah row status pada table menjadi -1 (DELETE)
     * 
     * @param      <type>                  $model  The model
     * @param      <type>                  $id     The identifier
     *
     * @throws     \yii\web\HttpException  (description)
     *
     * @return     array
     */
    public static function deleteData( $model, $id )
    {
        $model = $model::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        $model->row_status = -1;
        if ( $model->save() )
        {
            return [ 'status' => true, 'id' => $model->tableSchema->primaryKey ];
        } else {
            $errorMessage = static::getError($model);
            return [ 'status' => false, 'message' => $errorMessage ];
        }

    }

    /**
     * Lists
     * Showing data by row_status filter
     * 
     * @return  object      The Model Data
     */
    public static function lists()
    {
        $rowCondition = ['>', static::tableName() . '.row_status', -1];
        return static::find()->andWhere($rowCondition);
    }
}