<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="box">

	<div class="box-header">
	  	<h3 class="box-title">Gallery</h3> 
	  	<div class="pull-right">
			<a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#modalCreateFile">Upload new file</a>
	  	</div>
		<hr>

	</div>

	<div class="box-body">

		<div class="row media-manager">

			<!-- Gallery Images Section -->
			<div class="col-md-9">	
				<div class="row">
<?php
					foreach ( $fileDatas as $file ) {
?>
                      	<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 image">
                       	 	<div class="thmb">
                       	 		<div class="btn-group fm-group" style="">
                                  	<button 
                                  		type="button" 
                                  		class="btn btn-default dropdown-toggle fm-toggle" 
                                  		data-toggle="dropdown">
                                    	<span class="caret"></span>
                                  	</button>
                                  	<ul class="dropdown-menu fm-menu pull-right" role="menu">
                                  		<li>
                                  			<a href="<?= Url::to(['media-uploader/setting', 'type' => 'medium', 'id' => $file->id ]) ?>">
                                  				<i class="fa fa-crop"></i> Set medium size
                                  			</a>
                                  		</li>
                                  		<li>
                                  			<a href="<?= Url::to(['media-uploader/setting', 'type' => 'thumb', 'id' => $file->id ]) ?>">
                                  				<i class="fa fa-crop"></i> Set thumbnail size
                                  			</a>
                                  		</li>
                                  		<li>
                                        	<a href="<?= BASE_URL . $file->folder->directory . $file->id . '/' . $file->name ?>" download="<?= $file->name ?>" class="fm-menu__saveImage"> 
                                        		<i class="glyphicon glyphicon-floppy-disk"></i> Save as image
                                        	</a>
                                  		</li>
                                  		<li>
                                        	<a href="#" 
						    					data-clipboard-text="<?= BASE_URL . $file->folder->directory . $file->id . '/' . $file->name ?>" class="fm-menu__copyImageLink"> 
                                        		<i class="fa fa-copy"></i> Copy image link
                                        	</a>
                                  		</li>
                                        <li>
                                        	<a href="#" 
						    					data-action="<?= Url::to(['media-uploader/delete-file', 'id' => $file->id ]) ?>" 
						    					data-toggle="modal" 
						    					data-target="#confirmDelete" href="#">
                                        		<i class="fa fa-trash-o"></i> Delete
                                        	</a>
                                        </li>
                                  	</ul>
                                </div>
	                          	<div class="thmb-prev">
		                            <a href="" data-image="<?= BASE_URL . $file->folder->directory . $file->id . '/' . $file->name ?>" data-title="<?= $file->title ?>" data-toggle="modal" data-target="#modalShowimage" class="imageModal" >
		                              	<img src="<?= BASE_URL . $file->folder->directory . $file->id . '/thumb_' . $file->name ?>?<?= $file->updated_at ?>" class="img-thumbnail">
		                            </a>
	                          	</div>
                          		<h5 class="fm-title">
                          			<p><i class="fa fa-folder"></i> <?= $file->folder->directory . $file->id . '/' . $file->name ?> </p>
                          			<a href=""><?= $file->title ?></a>
                          		</h5>
                          		<small class="text-muted">Added: <?= date('M d, Y H:i A', $file->created_at) ?></small>
                        	</div><!-- thmb -->
                      	</div><!-- col-xs-6 -->
<?php 				
					} 
?>
				</div>
			</div>

			<!-- Folder Sidebar Section -->
			<div class="col-md-3">
				<div class="media-manager-sidebar">
				                              
				  
				  	<div class="mb30"></div>
				  
				  	<h5 class="lg-title">Folders <a href="" class="pull-right" data-toggle="modal" data-target="#modalCreateFolder" id="addNewFolder">+ Add New Folder </a></h5>

				  	<ul class="folder-list">

<?php
				  		foreach ( $folderData as $folder ):

				  			$dirLength = substr($folder->directory, 16);
?>

					    	<li class="folder-list__event">
					    		<a href="<?= Url::to(['media-uploader/index', 'folderId'=> $folder->id ]) ?>"><i class="fa fa-folder-o"></i><?= $folder->name ?></a>
					    		<ul class="folder-list__options">
					    			<li>
					    				<a href="" class="folder-list__edit" 
					    					data-id="<?= $folder->id ?>" 
					    					data-name="<?= $folder->name ?>" 
					    					data-medium-width="<?= $folder->medium_width ?>" 
					    					data-medium-height="<?= $folder->medium_height ?>" 
					    					data-thumb-width="<?= $folder->thumbnail_width ?>" 
					    					data-thumb-height="<?= $folder->thumbnail_height ?>" 
					    					data-directory="<?= substr($folder->directory, 15) ?>" 
					    					data-toggle="modal" 
					    					data-target="#modalCreateFolder">
					    					<i class="fa fa-pencil"></i> Edit
					    				</a>
					    			</li>
					    			<li>
					    				<a href="#" 
					    					data-action="<?= Url::to(['media-uploader/delete-folder','id' => $folder->id ]) ?>" 
					    					data-toggle="modal" 
					    					data-target="#confirmDelete">
					    					<i class="fa fa-times"></i> Delete
					    				</a>
					    			</li>
					    		</ul>
					    	</li>
<?php
						endforeach;
?>
				  		<li class="folder-list__event">
					    		<a href="<?= Url::to('media-uploader/index') ?>"><i class="fa fa-folder-o"></i>All</a>
				 	</ul>
				  
				  	<div class="mb30"></div>
				  
				</div>
			</div>

			<!-- Pagination Section -->
			<div class="col-md-12">
				<hr>
				<nav aria-label="Page navigation">
					<?= LinkPager::widget( [ 'pagination' => $filePages, 'hideOnSinglePage' => false ] ) ?>
				</nav>
			</div>

		</div>

	</div>


</div>

<!-- Create folder modal -->
<?= $this->render( 'modals/create-folder.php', ['folderModel' => $folderModel ] ) ?>

<!-- Upload file modal -->
<?= $this->render( 'modals/upload-file.php', [ 'fileModel' => $fileModel, 'folderLists' => $folderLists ] ) ?>

<?= $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.0/clipboard.min.js') ?>

<?php
$js = <<<JS

var clipboard = new Clipboard('.fm-menu__copyImageLink');

$(document).ready(function(){ 

 	document.oncontextmenu = function() {return false;};

    $('.save-image').click(function(){
		var link = document.createElement('fm-menu__saveImage');
		document.body.appendChild(link);
		link.click();     
   });

 	// Show Modal for Create new Folder 
 	$('#addNewFolder').click(function(){ 
 		$('#mediafolder-id').val();
 		$('#mediafolder-name').attr('value', '');
 		$('#mediafolder-directory').attr('value', '');
 	});
 	// Rightclick Menu
  	$('.folder-list__event').mousedown(function(e){ 
    	if( e.button == 2 ) { 
      		$(this).children().show();

      		return false; 
    	} 
    	return true; 
  	}); 

  	// If the document is clicked somewhere
	$(document).bind("mousedown", function (e) {
	    
	    // If the clicked element is not the menu
	    if (!$(e.target).parents(".folder-list__options").length > 0) {
	        
	        // Hide it
	        $(".folder-list__options").hide(100);

	    }
	});

	// Rename folder
	$('.folder-list__edit').click(function(){

        $('#mediafolder-id').val( $(this).attr('data-id') );
        $('#mediafolder-name').attr( 'value', $(this).attr('data-name') );
        $('#mediafolder-medium_width').attr( 'value', $(this).attr('data-medium-width') );
        $('#mediafolder-medium_height').attr( 'value', $(this).attr('data-medium-height') );
        $('#mediafolder-thumbnail_width').attr( 'value', $(this).attr('data-thumb-width') );
        $('#mediafolder-thumbnail_height').attr( 'value', $(this).attr('data-thumb-height') );
        $('#mediafolder-directory').attr( 'value', $(this).attr('data-directory') );

	});

});
JS;

$this->registerJs($js);