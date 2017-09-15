<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->beginPage(); 
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

	<head>

	    <meta charset="<?= Yii::$app->charset ?>">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <?= Html::csrfMetaTags() ?>
	    <title><?= Html::encode($this->title) ?></title>
	    <?php $this->head() ?>
	    <base href="<?= Yii::$app->homeUrl; ?>">
	</head>

	<body class="hold-transition skin-black-light sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">

			<?= $this->render('/partials/side-header.php'); ?>
			<?= $this->render('/partials/side-bar.php'); ?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">

				<?= $this->render('/partials/content-header.php'); ?>

			    <!-- Main content -->
			    <section class="content"> 
					<?= $this->render('/partials/alert.php'); ?>
					<?= $content ?>
			   	</section>
			    <!-- /.content -->
			</div>
			<!-- /.content-wrapper -->                                                                                 
			
			<?= $this->render('/partials/footer.php'); ?>
			<?= $this->render('/partials/side-control.php'); ?>

			<?= $this->render('/partials/modals/popupImage.php'); ?>
			<?= $this->render('/partials/modals/confirmDelete.php'); ?>

		</div>
		<!-- ./wrapper -->

<?php
$controller = Yii::$app->controller->id;
$js = <<<EOF
	    $('.dataTableAjax').dataTable({
	        "sDom" : "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", //default layout without horizontal scroll(remove this setting to enable horizontal scroll for the table)
	        "iDisplayLength": 20,
	        "lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
	        "bProcessing": true,
	        "bServerSide": true,
	        "sAjaxSource": "$controller/list-of-data",
	        // set the initial value
	        "oLanguage": {
	            "sProcessing": '<i class="fa fa-coffee"></i>&nbsp;Please wait...',
	            "sLengthMenu": "_MENU_ records",
	            "oPaginate": {
	                "sPrevious": "Prev",
	                "sNext": "Next"
	            }
	        },
	        "ordering": false
	    });

EOF;

$this->registerJS($js); 
?>

	
	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>
