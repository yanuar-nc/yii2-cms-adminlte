<?php

namespace backend\components;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;

use backend\components\AccessRule;
use backend\components\MenuComponent;
use backend\models\User;

class View extends \yii\web\View
{

    /**
     * Initialization
     * 
     * @return void
     */
    public function init()
    {
        parent::init();

        $app = Yii::$app;
        /** Check, apakah ada session user atau tidak */
        if ( !empty($app->user->identity) )
        {
            
            $user = $app->user->identity;
            $menu = new MenuComponent($user);

            ///Set parameter towards view///
            $image = !empty($user['image']) ? $app->params['baseUrl'] . '/media/users/' . $user['id'] . '/thumb_' . $user['image'] :  $app->homeUrl . '/img/avatar5.png';
            $this->params['user'] = [ 
                'id' =>         $user['id'], 
                'fullname' =>   $user['fullname'], 
                'image' =>      $image,
                'position' =>   $user['position'],
                'roleCode' =>   $user['role'],
                'role' =>       User::$role[ $user['role'] ],
                'created_at' => date('d F Y', $user['created_at'] )
            ];
            $this->params['userAction']  = AccessRule::getActions( $user['role'] );
            $this->params['menus']       = $menu->getMenu();
        }
    }

    /**
     * Gets the action buttons.
     *
     * @param      <type>  $actions   The actions
     * @param      <type>  $roleCode  The role code
     *
     * @return     string  The action buttons.
     */
    public function getActionButtons( $actions, $roleCode )
    {

        $getAccess = AccessRule::actionAccess( array_flip($actions), $roleCode );

        $buttons = null;
        foreach ( $getAccess as $action => $status ) {
            if ( $status == true ) 
            {
                $buttons .= '<li><a href="' . $actions[ $action ] . '">' . ucfirst($action) . '</a></li>';
            }
        }

        if ( $buttons != null ) {

            $result = '
            <div class="btn-group">
                <button type="button" class="btn btn-default">Action</button>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">' . $buttons . '</ul>
            </div>';

        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * Builds a form.
     *
     * @param      <type>  $model   The model
     * @param      <type>  $fields  The fields
     * 
     * @return void
     */
    public function buildForm( $model, $fields )
    {
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

        echo '<div class="box-body">';
        foreach ( $fields as $field => $components ) {

            $element = is_array($components) ? key($components) : 'textInput'; // Default untuk form innput adalah text
            $field   = is_string( $field ) ? $field : $components; // Bila tidak memilki komponen attribute

            if ( !is_string( $element ) ) {
                $element = $components[$element];
            }

            /**
             * validasi fileinput menjadi tidak memiliki class
             * default @uses form-control {bootstrap3}
             */
            switch ($element) {
                case 'fileInput':
                    $class = '';
                break;
                default:
                    $class = 'form-control'; 
                break;
            }


            ///Handling extension, list menu dan inputOptions///
            $extension = [];
            $label     = $model->getAttributeLabel($field);
            $options   = [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel($field),
                    'class' => $class
                ],
            ];
            if ( is_array($components) && is_string( key($components) ) ) 
            {
                if ( isset($components[ $element ]['options']) )
                {
                    $options[ 'inputOptions' ] = $components[ $element ]['options'] + $options[ 'inputOptions' ];                    
                }

                /**
                 * Handling list menu
                 * 
                 * @category dropDownList, radioList, checkboxList, dll   
                 * @see http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html
                 */
                if ( isset($components[ $element ]['list']) )
                {
                    $extension = $components[ $element ]['list'];
                }

            }

            // Field id tidak memiliki label
            if ($field == 'id') { $element = 'hiddenInput'; $label = false; }

            if ( substr($field, 0, 7) === 'Related' )
            {
            }

            /**
             * Untuk kepentingan widget-widget berdasrkan element
             * 
             * @uses CurrentModel::formData()
             * 
             * @example 
             * public static function formData()
             * {
             *      return [
             *          'title' => [
             *              'textInput'    <<<========= This called is $element 
             *           ]
             *      ]
             * }
             */
            
            switch ($element) {

                case 'datePicker':
                case 'dateTimePicker':

                    echo '<div class="form-group">';
                    echo '<label class="control-label" for="">' . $model->getAttributeLabel($field) . '</label>';

                    switch ($element) {
                        case 'datePicker':
                            echo DatePicker::widget([
                                'model' => $model,
                                'attribute' => $field, 
                                'value' => date('yyyy-mm-dd', isset($element->value) ? $element->value : null),
                                'options' => ['placeholder' => 'Insert date'],
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true
                                ]
                            ]);
                        break;
                        case 'dateTimePicker':
                            echo DateTimePicker::widget([
                                'model' => $model,
                                'attribute' => $field, 
                                'value' => date('Y-m-d H:i:s', isset($element->value) ? $element->value : null),
                                'options' => ['placeholder' => 'Insert date time'],
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'todayHighlight' => true
                                ]
                            ]);
                        break;
                        
                    }
                    echo Html::error($model, $field, ['style' => 'color: #C54466']);
                    echo "</div>";
                break;

                case 'fileInput':

                    if ( !empty( $model->$field ) )
                    {

                        $fileDir    = isset($model::$uploadFile[ $field ]['path']) ? 
                                      $model::$uploadFile[ $field ]['path'] : 
                                      $model::tableName(); 

                        $filePath   = BASE_URL . '/' . 
                                     basename(ASSETS_PATH) . '/' . 
                                     $fileDir . '/' . 
                                     $model->id . '/';
                        $imageFull  =  $filePath . $model->$field;
                        $imageThumb = file_exists(ASSETS_PATH.'/'.$fileDir . '/' . $model->id . '/' .'thumb_' . $model->$field) ? $filePath . 'thumb_' . $model->$field : $imageFull;

                        $fileInfo      = pathinfo($imageFull);
                        $fileExtension = $fileInfo[ 'extension' ];
                        
                        $imageType  = [ 'gif', 'png', 'jpg', 'jpeg' ];
                        if ( in_array( $fileInfo[ 'extension' ], $imageType ) )
                        {

                            echo '
                                <div class="form-group">
                                    <label class="control-label">Current ' . $model->getAttributeLabel($field) . '</label>
                                    <a href="#" data-image="' . $imageFull . '" data-toggle="modal" data-target="#modalShowimage" class="imageModal"> 
                                        <img class="img-responsive" src="' . $imageThumb . '" alt="Photo" width="120px">
                                    </a>
                                    <p class="help-block help-block-error"></p>
                                </div>';

                        }

                    }

                    echo $form->field($model,  $field, $options)->$element($extension)->label($label);  
                    // var_dump($model->image);exit;
                    // echo $form->field($model,  $field, $options)->$element($extension)->label($label);  
                break;
                
                case 'mediaUploader':

                    if ( !empty( $model->$field ) )
                    {
                        $this->getCurrentImage( $model, $field );
                    }

                    echo '
                        <button type="button" 
                            class="btn btn-default btn-flat mediaUploader__buttonModal" 
                            data-toggle="modal" 
                            data-target="#mediaUploader__modal">
                                Set ' . $model->getAttributeLabel($field) . '
                        </button>';

                    echo $form->field($model,  $field, $options)->hiddenInput($extension)->label(false);  
                    echo $form->field($model,  $field . '_dir', $options)->hiddenInput($extension)->label(false);  
                break;

                default:
                   echo $form->field($model,  $field, $options)->$element($extension)->label($label);  
                break;
            }

        }

        echo '</div>'; ///end box body

        echo '<div class="box-footer">
                    <a href="javascript:history.go(-1);" class="btn btn-warning btn-flat">Go Back</a>.
                    &nbsp;
                    <button type="submit" class="btn btn-default btn-flat">Save new item</button>
              </div>';
        ActiveForm::end();

    }

    public function datePicker( $model, $field, $label = 'Insert Date', $value = null )
    {
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => $field, 
            'value' => date('yyyy-mm-dd', $value),
            'options' => ['placeholder' => 'Insert date'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]);

    }
    private function getCurrentImage( $model, $field ) 
    {

        $fieldDirectory = $field . '_dir';
        $filePath   = $model->$fieldDirectory; 

        $imageFull  =  $filePath . $model->$field;
        $imageThumb =  $filePath . 'thumb_' . $model->$field;

        $fileInfo      = pathinfo($imageFull);
        $fileExtension = $fileInfo[ 'extension' ];
        
        $imageType  = [ 'gif', 'png', 'jpg', 'jpeg' ];

        if ( in_array( $fileInfo[ 'extension' ], $imageType ) )
        {

            echo '
                <div class="form-group">
                    <label class="control-label">Current ' . $model->getAttributeLabel($field) . '</label>
                    <a href="#" data-image="' . $imageFull . '" data-toggle="modal" data-target="#modalShowimage" class="imageModal"> 
                        <img class="img-responsive" src="' . $imageThumb . '" alt="Photo" width="120px">
                    </a>
                    <p class="help-block help-block-error"></p>
                </div>';

        }
    }

    /**
     * Contextual Row
     * Untuk memberikan class pada row di table
     *
     * @param      integer  $status  The status
     */
    public function contextualRow($status)
    {
        switch ($status) {
            case 0:
                $class = 'warning';
            break;
            case -1:
                $class = 'danger';
            break;
            
            default:
                $class = null;
            break;
        }
        if ($status < 1)
        {
            echo "class=$class";
        }
    }

    public static function deleteButton($route)
    {
        return '<a href="#" data-action="'.Url::to($route).'" data-toggle="modal" 
                                            data-target="#confirmDelete"><i class="fa fa-times"></i> Delete</a>';
    }

    public static function updateButton($route)
    {
        return '<a href="'.Url::to($route).'"><i class="fa fa-edit"></i> Update</a>';
    }

    public static function groupButton($datas)
    {

        $buttons = '';
        foreach( $datas as $name => $url )
        {
            if ( $name == 'Delete' )
            {
                $buttons .= '<li><a href="#" data-action="'.Url::to($url).'" data-toggle="modal" 
                                            data-target="#confirmDelete">Delete</a>';
            } else {
                $buttons .= '<li><a href="' . Url::to($url) . '">' . $name . '</a></li>';
            }
        }
        $result = '
        <div class="btn-group">
            <button type="button" class="btn btn-default">Action</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">' . $buttons . '</ul>
        </div>';

        return $result;
    }

    public static function getImage($image, $thumb)
    {
        return '<a href="#" data-image="' . $image . '" data-toggle="modal" data-target="#modalShowimage" class="imageModal"> 
                        <img class="img-responsive" src="' . $thumb . '" alt="Photo" width="120px">
                    </a>';
    }
}