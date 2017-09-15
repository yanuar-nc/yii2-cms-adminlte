<div class="row">
	<div class="col-xs-12">

<?php

		$session = Yii::$app->session;

		if ( $session->hasFlash('success') ){
?>

			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Success!</h4>
				<?= $session->getFlash('success') ?>
			</div>		
<?php
		}

		if ( $session->hasFlash('danger') ){
?>
			<div class="alert alert-danger alert-ban">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-times"></i> Error!</h4>
				<?= $session->getFlash('danger') ?>
			</div>

<?php 	}
		
		if ( $session->hasFlash('warning') ){
?>
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-warning"></i> Warning!</h4>
				<?= $session->getFlash('warning') ?>
			</div>
<?php
		}

		if ( $session->hasFlash('info') ){
?>
			<div class="alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-info"></i> Info!</h4>
				<?= $session->getFlash('info') ?>
			</div>
<?php
		}
?>
	</div>
</div>