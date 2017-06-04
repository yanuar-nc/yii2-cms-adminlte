<div class="modal fade" id="modalCreateFile" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="modalLabel">Upload File</h4>
	      	</div>

			{% set form = active_form_begin( { 
				'action': 'upload-file',
				'options': { 'enctype': 'multipart/form-data' }
			}) %}

		    <div class="modal-body">
			    {{ form.field(fileModel, 'media_folder_id').dropDownList(folderLists) | raw }}
			    {{ form.field(fileModel, 'title').textInput() | raw }}
			    {{ form.field(fileModel, 'description').textarea() | raw }}
			    {{ form.field(fileModel, 'name').fileInput() | raw }}

		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		    </div>

			{{ active_form_end() }}

	    </div>
  	</div>
</div>