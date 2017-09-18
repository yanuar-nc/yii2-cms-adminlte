<?php
use yii\widgets\ActiveForm;
?>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <?php $form = ActiveForm::begin( [ 'id' => 'login-form' ] ); ?>

        <div class="form-group has-feedback">
            <?= $form->field( $model, 'fullname' )->textInput( [ 'placeholder' => 'Fullname' ] )->label( false ); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'position')->textInput( [ 'placeholder' => 'Position' ] )->label(false); ?>
            <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'email')->textInput( [ 'placeholder' => 'Email' ] )->label(false); ?>
            <span class="fa fa-envelope-o form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'username')->textInput( [ 'placeholder' => 'Username' ] )->label(false); ?>
            <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'password')->passwordInput( [ 'placeholder' => 'Password' ] )->label(false); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?= $form->field( $model, 'rePassword')->passwordInput( [ 'placeholder' => 'Re-password' ] )->label(false); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat btn-block">Sign Up</button>
            </div>
        <!-- /.col -->
        </div>

        <?php ActiveForm::end() ?>
        <!-- /.social-auth-links -->

    </div>
  <!-- /.login-box-body -->

<?= $this->registerJs("  

$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });"); ?>
