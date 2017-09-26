<?php
use yii\widgets\ActiveForm;
?>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Forgot Password</p>

        <?php $form = ActiveForm::begin( [ 'id' => 'login-form' ] ); ?>

        <div class="form-group has-feedback">
            <?= $form->field( $model, 'newPassword' )
                ->passwordInput( [ 'placeholder' => 'New Password' ] )
                ->label( false ); 
            ?>
            <?= $form->field( $model, 'rePassword' )
                ->passwordInput( [ 'placeholder' => 'Re Password' ] )
                ->label( false ); 
            ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat btn-block">Submit</button>
            </div>
        <!-- /.col -->
        </div>

        <?php ActiveForm::end() ?>
        <!-- /.social-auth-links -->

    </div>
  <!-- /.login-box-body -->
<?= $this->registerJs( '
$("#user-newpassword").focus();
    ' 
); ?>