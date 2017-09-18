<div class="box box-primary">
    
    <div class="box-header with-border">
        <h3 class="box-title">Form</h3>
    </div>
    <!-- /.box-header -->

    <?= $this->buildForm( $model, $fields ) ?>
</div>

<!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#mediaUploader__modal">
	Launch demo modal
</button> -->
<div id="fileName"></div>
<div id="fileDirectory"></div>


<!-- Modal -->
<div class="modal fade" id="mediaUploader__modal" style="overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Media Uploader
					<button class="btn btn-default btn-flat pull-right" data-toggle="modal" data-target="#uploadFile__modal">Add new</button>
				</h4>
				
			</div>
			<div class="modal-body">
				<div class="row">	
					<div class="col-md-12">
					<form class="form-horizontal">
					  	<div class="form-group">
						    <div class="col-md-4">
						    	<select id="mediaFile__folders" class="form-control mediaFolder__lists" name="MediaFile[media_folder_id]" aria-required="true" aria-invalid="false">
						    		<!-- rendered by ajax -->
						    	</select>
							</div>
					  	</div>
					</form>
					</div>
				</div>
				<hr style="margin-top: 0">

				<!-- Render File Image -->
				<div class="row mb15">
					<div id="mediaFile__list">
						<!-- rendered by ajax -->
	    			</div>
    			</div>
    			<div class="row">
	    			<div class="col-xs-2 col-xs-offset-5">
	    				<button class="btn btn-flat btn-default btn-block" id="mediaFile__loader" data-offset='12' >&nbsp; Load more &nbsp;</button>
	    			</div>
    			</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flat btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-flat btn-primary" id="mediaUploader__setImage" data-file="">Set Image</button>
			</div>
		</div>
  	</div>
</div>


<!-- Modal File Upload -->
<div class="modal fade" id="uploadFile__modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">New File</h4>
	      	</div>
	      	<div class="modal-body">
		        <form id="w1" action="upload-file" method="post" enctype="multipart/form-data">
		        	<input name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" type="hidden">
		        	<div class="modal-body">
		        		<div class="form-group field-mediafile-media_folder_id required has-success">
		        			<label class="control-label" for="mediafile-media_folder_id">Folder</label>
		        			<select id="uploadFile__folders" class="form-control mediaFolder__lists" name="MediaFile[media_folder_id]" aria-required="true" aria-invalid="false">
		        				<!-- rendered by ajax -->
		        			</select>
		        			<p class="help-block help-block-error"></p>
		        		</div>
		        		<div class="form-group field-mediafile-title required">
		        			<label class="control-label" for="mediafile-title">Title</label>
		        			<input name="MediaFile[title]" value="" class="form-control">
		        			<p class="help-block help-block-error"></p>
		        		</div>
		        		<div class="form-group field-mediafile-description">
		        			<label class="control-label" for="mediafile-description">Description</label>
		        			<textarea name="MediaFile[description]" class="form-control"></textarea>
		        			<p class="help-block help-block-error"></p>
		        		</div>
		        		<div class="form-group field-mediafile-name required">
		        			<label class="control-label" for="mediafile-name">File</label>
		        			<input name="MediaFile[name]" value="" type="hidden">
		        			<input id="mediafile-name" name="MediaFile[name]" aria-required="true" type="file">
		        			<p class="help-block help-block-error"></p>
		        		</div>
		        	</div>
		        	<div class="modal-footer">
		        		<button type="button" class="btn btn-flat btn-default" id="uploadFile__close" data-dismiss="modal">Close</button>
		        		<button type="submit" class="btn btn-flat btn-primary" id="uploadFile__save">Upload</button>
		        	</div>
		        </form>
	      	</div>
    	</div>
  	</div>
</div>

<?= $this->render('/partials/ajax-loader.php') ?>

<?php 
$baseUrl = Yii::$app->params['baseUrl'];
$urlGetFiles = \yii\helpers\Url::to( ['media-uploader/ajax-get-files'] );
$urlGetFolders = \yii\helpers\Url::to( ['media-uploader/ajax-get-folders'] );
$urlUploadFile = \yii\helpers\Url::to( ['media-uploader/ajax-upload-file'] );
$js = <<<JS

var loading = $('#ajaxLoader').hide();

$(document)
	
  	.ajaxStart(function () {
    	loading.show();
  	})
  	.ajaxStop(function () {
    	loading.hide();
 	});

function setImage( instance, targetName)
{

	$( targetName ).val( instance.attr('data-file') );		
	// $( targetDirectory ).val( instance.attr('data-directory') );		

}

$('#mediaUploader__setImage').on('click', function(){
	
	setImage( $(this), $(this).attr('data-field') )
	$('#mediaUploader__modal').modal('hide')
});

$('.mediaUploader__buttonModal').click(function(){
	
	$('#mediaUploader__setImage').attr( {
		'data-field': "#" + $(this).next('div').children('input').attr('id'),
		// 'data-field-directory': "#" + $(this).next('div').children('input').attr('id') + '_dir'
	} );

});

mediaUploader__data = false;
$('#mediaUploader__modal').on('show.bs.modal', function (e) {
	
	if ( mediaUploader__data == false )
	{
		$.ajax({
			url: "$urlGetFiles",
			success: function(response) {

				mediaUploader__render(response, 'html');
			}
		})

		$.ajax({
			url: "$urlGetFolders",
			success: function(response) {

				var folderList = '';
				$.each( response, function( key, folder ) {
					folderList += '<option value="' + folder.id + '">' + folder.name + '</option>';
				});
				$('#mediaFile__folders').html( '<option>All</option>' + folderList );
				$('#uploadFile__folders').html( folderList );
			}
		})
		mediaUploader__data = true;
	}

})

$('#uploadFile__close').on('click', function(){
	
	$('#uploadFile__modal').modal('hide');

});

$('#mediaFile__folders').on('change', function(){
	
	$('#mediaFile__loader').attr('data-offset', 4);

	$.ajax({
		url: "$urlGetFiles",
		data: { folder_id:  $(this).val() },
		success: function(response) {
			mediaUploader__render(response, 'html');
		},
		complete: function(data) {
		}
	})

});

$('#uploadFile__save').on('click', function() {


    $.ajax({

        url: "$urlUploadFile",
        type: 'POST',

        // Form data
        data: new FormData($('#w1')[0]),

        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
        	if ( data.status == true )
        	{
        		$('#uploadFile__modal').modal('hide');

        		result =  '<div class="col-xs-6 col-md-3">' + 
	    					'<img src="' + data.thumb + '" class="img-responsive mediaFile__image mediaFile__image img-thumbnail" data-file=\'' + data.data + '\'>' + 
		    				'<input type="checkbox" class="hidden">' + 
		    			'</div>';
		    	$('#mediaFile__list').prepend(result);

        	}
        }

    });
    
    return false;

});


$('#mediaFile__loader').on( 'click', function(){

	$(this).text('Loading...')

	$.ajax({
		url: "$urlGetFiles",
		data: { offset: $(this).attr('data-offset'), 'folder_id': $('#mediafile-media_folder_id').val() },
		success: function(response) {

			$('#mediaFile__loader').attr('data-offset', response.offset);
			$('#mediaFile__loader').text('Load more')
					
			mediaUploader__render(response);
		},
		complete: function(data) {
		}
	})

});

$(document).on( 'click', '.mediaFile__image', function() {

    $('.mediaFile__image').not(this).removeClass('active')
		.siblings('input').prop('checked',false)
        .siblings('.mediaFile__image').css({'opacity': '0.5', 'border-color': '#ddd'});

	$(this).addClass('active')
        .siblings('input').prop('checked',true)
		.siblings('.mediaFile__image').css({'opacity': '1', 'border-color': '#367FA9'});

	$('#mediaUploader__setImage').attr( { 
		'data-file': $(this).attr('data-file'),
	} );
})

function mediaUploader__render(response, type='append') 
{

	if ($('#mediaFile__loader').attr('data-offset') >= response.count) 
	{
		$('#mediaFile__loader').hide();
	} else {
		$('#mediaFile__loader').show();
	}

	result = ''
	$.each( response.files, function(key, file) {
		result += '<div class="col-xs-6 col-md-3">' + 
	    				'<img src="' + file.thumb + '" class="img-responsive mediaFile__image img-thumbnail" data-file=\'' + file.data + '\'>' + 
	    				'<input type="checkbox" class="hidden">' + 
	    			'</div>';

	})
	if ( type == 'append' )
		$('#mediaFile__list').append(result);
	else 
		$('#mediaFile__list').html(result);
}


CKEDITOR.plugins.addExternal( 'imagebrowser', '$baseUrl/backend/plugins/ckeditor/plugins/imagebrowser/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'colorbutton', '$baseUrl/backend/plugins/ckeditor/plugins/colorbutton/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'panelbutton', '$baseUrl/backend/plugins/ckeditor/plugins/panelbutton/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'colordialog', '$baseUrl/backend/plugins/ckeditor/plugins/colordialog/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'image2', '$baseUrl/backend/plugins/ckeditor/plugins/image2/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'justify', '$baseUrl/backend/plugins/ckeditor/plugins/justify/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'widget', '$baseUrl/backend/plugins/ckeditor/plugins/widget/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'lineutils', '$baseUrl/backend/plugins/ckeditor/plugins/lineutils/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'clipboard', '$baseUrl/backend/plugins/ckeditor/plugins/clipboard/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'widgetselection', '$baseUrl/backend/plugins/ckeditor/plugins/widgetselection/', 'plugin.js' );

$('.ckeditor').each(function(e){

	CKEDITOR.replace(this.id, {
		"extraPlugins" : 'imagebrowser,colorbutton,colordialog,panelbutton,justify,image2,widget,lineutils,clipboard,widgetselection',
		"imageBrowser_listUrl" : "{{ url( ['media-uploader/ajax-ckeditor-image'] ) }}"
	});
});
JS;
?>
<?= $this->registerJs($js); ?>