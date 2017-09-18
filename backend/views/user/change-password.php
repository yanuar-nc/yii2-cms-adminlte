<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="box box-primary">
		    
		    <div class="box-header with-border">
		        <h3 class="box-title">Change Password</h3>
		    </div>
		    <!-- /.box-header -->

		    <div class="box-body">
		    	<?php
		        $form = ActiveForm::begin([
		            'options' => [ 'autocomplete' => 'off' ] 
		        ]);

		            echo $form->field( $model, 'oldPassword')->passwordInput()->label('Old Password');
		            echo $form->field( $model, 'newPassword')->passwordInput()->label('New Password');
		            echo $form->field( $model, 'rePassword')->passwordInput()->label('Re-Password');
		        ?>
	                <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>

		        <?php ActiveForm::end(); ?>
		    </div>
		</div>

	</div>
</div>
