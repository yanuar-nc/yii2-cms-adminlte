<div class="modal fade" id="modalCreateFile" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modalLabel">Upload File</h4>
	      	</div>

			<?php 
			$form = yii\widgets\ActiveForm::begin([
				'action' => 'media-uploader/upload-file',
				'options' => ['enctype' => 'multipart/form-data']
			]); 
			?>
		    <div class="modal-body">
		    	<?= $form->field( $fileModel, 'media_folder_id' )->dropDownList($folderLists) ?>
		    	<?= $form->field( $fileModel, 'title' )->textInput() ?>
		    	<?= $form->field( $fileModel, 'description' )->textarea() ?>
		    	<?= $form->field( $fileModel, 'name' )->fileInput(['accept' => '.png, .jpg, .jpeg']) ?>

		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		    </div>

			<?php yii\widgets\ActiveForm::end() ?>

	    </div>
  	</div>
</div>