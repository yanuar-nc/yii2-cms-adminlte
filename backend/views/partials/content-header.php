<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?= $this->params['title'] ?>
		<small><?= $this->params['description'] ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="site/index"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?= Yii::$app->controller->id ?>/index"><?= ucwords( str_replace('-', ' ', Yii::$app->controller->id ) ) ?></a></li>
		<li class="active"><?= ucwords( str_replace('-', ' ', $this->context->action->id ) ) ?></li>
	</ol>
</section>