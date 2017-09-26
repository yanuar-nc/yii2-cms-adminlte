<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="box box-primary">
		    
		    <div class="box-header with-border">
		        <h3 class="box-title">Reset Password</h3>
		    </div>
		    <!-- /.box-header -->

		    <div class="box-body">
		    	<?php
		        $form = ActiveForm::begin([
		            'options' => [ 'autocomplete' => 'off' ] 
		        ]);

		        ?>
				<div class="form-group field-user-password required">
					<label class="control-label" for="user-password">New Password</label>
					<input type="password" id="user-password" class="form-control" name="User[password]" value="" aria-required="true" aria-invalid="false">

				</div>
                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>

		        <?php ActiveForm::end(); ?>
		    </div>
		</div>

	</div>
</div>
