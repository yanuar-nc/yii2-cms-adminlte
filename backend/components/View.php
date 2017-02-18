<?php

namespace backend\components;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
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
                'role' =>       User::ROLE[ $user['role'] ],
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
            $label     = true;
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
                 * @link http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html
                 */
                if ( isset($components[ $element ]['list']) )
                {
                    $extension = $components[ $element ]['list'];
                }

            }

            if ($field == 'id') { $element = 'hiddenInput'; $label = false; }

            /**
             * Untuk kepentingan widget-widget
             * @var string
             */
            if ( $element == 'datePicker' || $element == 'dateTimePicker' )
            {
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
            } elseif ( $element == 'fileInput' ) {

                if ( !empty( $model->$field ) )
                {

                    $fileDir    = isset($model::$uploadFile[ $model->$field ]['path']) ? 
                                  $model::$uploadFile[ $model->$field ]['path'] : 
                                  $model::tableName(); 

                    $filedata =  Yii::$app->params['baseUrl'] . '/' . 
                                 basename(ASSETS_PATH) . '/' . 
                                 $fileDir . '/' . 
                                 $model->id . '/' . 
                                 $model->$field;
                    $fileInfo      = pathinfo($filedata);
                    $fileExtension = $fileInfo[ 'extension' ];
                    
                    $imageType  = [ 'gif', 'png', 'jpg', 'jpeg' ];
                    if ( in_array( $fileInfo[ 'extension' ], $imageType ) )
                    {

                        echo '
                            <div class="form-group">
                                    <label class="control-label">Current ' . $model->getAttributeLabel($field) . '</label>
                                    <img class="img-responsive" src="' . $filedata . '" alt="Photo" width="120px">

                                    <p class="help-block help-block-error"></p>
                            </div>';

                    }

                }

                echo $form->field($model,  $field, $options)->$element($extension)->label($label);  
                // var_dump($model->image);exit;
                // echo $form->field($model,  $field, $options)->$element($extension)->label($label);  
            } else {
                echo $form->field($model,  $field, $options)->$element($extension)->label($label);  
            }

        }

        echo '</div>'; ///end box body

        echo '<div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
              </div>';
        ActiveForm::end();

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
}