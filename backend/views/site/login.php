<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'validateOnChange' => false,
            'options' => [ 'autocomplete' => 'off' ] 
        ]);
        ?>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'username')->textInput( ['placeholder' => 'Username'] )->label(false); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'password')->passwordInput( ['placeholder' => 'Password'] )->label(false); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <?= $form->field( $model, 'rememberMe', [ 'options' => [ 'class' => 'col-xs-6 col-xs-offset-3 mb15' ] ] )
                ->checkbox( [ 
                    'template' => '<div class="checkbox icheck">{beginLabel}{input}{labelTitle}{endLabel}{error}{hint}</div>' 
                ] )
                ->label(false); ?>
            <!-- /.col -->
            <br>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
        <!-- /.col -->
        </div>

        <?php ActiveForm::end() ?>
        <hr>
        <div class="social-auth-links text-center">
          <p>Don't have an account? Please contact administrator to get user login.</p>
        </div>
        <!-- /.social-auth-links -->

    </div>
  <!-- /.login-box-body -->

<?= $this->render('/partials/ajax-loader.php') ?>

<?= $this->registerJs("  

var loading = $('#ajaxLoader').hide();

$(document)
    
    .ajaxStart(function () {
        loading.show();
    })
    .ajaxStop(function () {
        loading.hide();
    });

$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

$(document).ready( 
    $('#login-form').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);
        if(form.find('.has-error').length) {
            return false;
        }
        
        $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(data) {
                    if (data.error) {
                        $.each(data.error, function(attribute, message){
                            $('#login-form').yiiActiveForm('updateAttribute', attribute, message);
                        });
                    }
                }
        });
        
        return false;
    })
);
"); ?>
