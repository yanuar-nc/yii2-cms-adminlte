<div class="modal fade" id="modalCreateFolder" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modalLabel">Create Folder</h4>
	      	</div>

			<?php $form = yii\widgets\ActiveForm::begin(['action' => 'media-uploader/create-folder']) ?>

		    <div class="modal-body">
		    	<?= $form->field( $folderModel, 'id' )->hiddenInput()->label(false) ?>
		    	<?= $form->field( $folderModel, 'name' ) ?>
		    	<?= $form->field( $folderModel, 'medium_width' )
		    		->textInput(['value' => 500])
		    		->hint('Size width of medium image (pixel)') 
		    	?>
		    	<?= $form->field( $folderModel, 'medium_height' )
		    		->textInput(['value' => 500])
		    		->hint('Size height of medium image (pixel)') 
		    	?>
		    	<?= $form->field( $folderModel, 'thumbnail_width' )
		    		->textInput(['value' => 120])
		    		->hint('Size width of thumbnail image (pixel)') 
		    	?>
		    	<?= $form->field( $folderModel, 'thumbnail_height' )
		    		->textInput(['value' => 120])
		    		->hint('Size height of thumbnail image (pixel)') 
		    	?>
		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		    </div>

			<?php yii\widgets\ActiveForm::end() ?>

	    </div>
  	</div>
</div>