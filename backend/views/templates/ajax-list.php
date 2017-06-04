<div class="box">

	<div class="box-header">
      	<h3 class="box-title"><?= $this->params['title'] ?></h3> 
      	<div class="pull-right">
      		<?php 
      		if (empty($disabledInsertNewItem)) {
      			echo $this->render('/partials/button/insert-default');
      		}
      		?>
      	</div>
    </div>
	<!-- /.box-header -->
	<div class="box-body">
		<table class="table table-striped table-bordered table-hover <?= empty($id) ? 'dataTableAjax' : '' ?>" class="">
			<thead>
				<tr>
					<?php foreach( $headers as $header ) { ?>
						<th><?= $header ?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr>
					<?php foreach( $headers as $header ) { ?>
						<th><?= $header ?></th>
					<?php } ?>
				</tr>
			</tfoot>
		</table>
	</div>
<!-- /.box-body -->
</div>