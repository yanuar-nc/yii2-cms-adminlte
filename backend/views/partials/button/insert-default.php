
<?php if (in_array('create', $this->params['userAction'])) { ?>
	<a href="<?= Yii::$app->controller->id ?>/create" class="btn btn-default btn-flat">
	    <i class="fa fa-plus"></i> Insert new item
	</a>
<?php } ?>