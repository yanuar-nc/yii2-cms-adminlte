

        <div class="row mb15">
            <div class="col-md-9">
                <!-- <h3>Demo:</h3> -->
                <div class="img-container">
                    <img id="image" src="<?= BASE_URL . '/' . $folder->directory . '/' . $file->id . '/' . $file->name ?>" alt="Picture" ratio="<?= $ratio ?>">
                </div>
            </div>
            <div class="col-md-3">
                <!-- <h3>Preview:</h3> -->
                <div class="docs-preview clearfix">
                    <div class="img-preview preview-lg"></div>
                    <div class="img-preview preview-md"></div>
                    <div class="img-preview preview-sm"></div>
                    <div class="img-preview preview-xs"></div>
                </div>

                <!-- <h3>Data:</h3> -->
                <div class="docs-data">
                <?php $form = yii\widgets\ActiveForm::begin(['id' => 'cropper__Form', 'options' => ['class' => 'form-horizontal']]) ?>

                    <input type="hidden" id="dataRatio" value="<?= $ratio ?>">

                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataX">X</label>
                        <input type="text" class="form-control" id="dataX" placeholder="x" name="x">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataY">Y</label>
                        <input type="text" class="form-control" id="dataY" placeholder="y" name="y">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataWidth">Width</label>
                        <input type="text" class="form-control" id="dataWidth" placeholder="width" name="w">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataHeight">Height</label>
                        <input type="text" class="form-control" id="dataHeight" placeholder="height" name="h">
                        <span class="input-group-addon">px</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataRotate">Rotate</label>
                        <input type="text" class="form-control" id="dataRotate" placeholder="rotate" name="r">
                        <span class="input-group-addon">deg</span>
                    </div>
                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataScaleX">ScaleX</label>
                        <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX" name="scaleX">
                    </div>
                    <div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataScaleY">ScaleY</label>
                        <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY" name="scaleY">
                    </div>
                    <input type="submit" value="Save!" class="btn btn-success btn-block btn-flat btn-block" id="cropper__Save">
                <?php yii\widgets\ActiveForm::end() ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 docs-buttons">
                <!-- <h3>Toolbar:</h3> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                            <span class="fa fa-arrows"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                            <span class="fa fa-crop"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, 0.1)">
                            <span class="fa fa-search-plus"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, -0.1)">
                            <span class="fa fa-search-minus"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, -10, 0)">
                            <span class="fa fa-arrow-left"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 10, 0)">
                            <span class="fa fa-arrow-right"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, -10)">
                            <span class="fa fa-arrow-up"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, 10)">
                            <span class="fa fa-arrow-down"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)">
                            <span class="fa fa-rotate-left"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)">
                            <span class="fa fa-rotate-right"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)">
                            <span class="fa fa-arrows-h"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)">
                            <span class="fa fa-arrows-v"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;crop&quot;)">
                            <span class="fa fa-check"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;clear&quot;)">
                            <span class="fa fa-remove"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;disable&quot;)">
                            <span class="fa fa-lock"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;enable&quot;)">
                            <span class="fa fa-unlock"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)">
                            <span class="fa fa-refresh"></span>
                        </span>
                    </button>
                    <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                        <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image with Blob URLs">
                            <span class="fa fa-upload"></span>
                        </span>
                    </label>
                    <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;destroy&quot;)">
                            <span class="fa fa-power-off"></span>
                        </span>
                    </button>
                </div>

                <div class="btn-group btn-group-crop">
                    <button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;)">
                            Get Cropped Canvas
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
                            160&times;90
                        </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 320, height: 180 })">
                            320&times;180
                        </span>
                    </button>
                </div>

                <!-- Show the cropped image in modal -->
                <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal -->

                <button type="button" class="btn btn-primary" data-method="getData" data-option data-target="#putData" javascript="return: false;">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getData&quot;)">
                        Get Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setData" data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setData&quot;, data)">
                        Set Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="getContainerData" data-option data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getContainerData&quot;)">
                        Get Container Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="getImageData" data-option data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getImageData&quot;)">
                        Get Image Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="getCanvasData" data-option data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCanvasData&quot;)">
                        Get Canvas Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setCanvasData" data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setCanvasData&quot;, data)">
                        Set Canvas Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="getCropBoxData" data-option data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCropBoxData&quot;)">
                        Get Crop Box Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setCropBoxData" data-target="#putData">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setCropBoxData&quot;, data)">
                        Set Crop Box Data
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="moveTo" data-option="0">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="cropper.moveTo(0)">
                        Move to [0,0]
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoomTo" data-option="1">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="cropper.zoomTo(1)">
                        Zoom to 100%
                    </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotateTo" data-option="180">
                    <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="cropper.rotateTo(180)">
                        Rotate 180°
                    </span>
                </button>
                <input type="text" class="form-control" id="putData" placeholder="Get data to here or set data with this value">
            </div><!-- /.docs-buttons -->

            <div class="col-md-3 docs-toggles">
                <!-- <h3>Toggles:</h3> -->
                <!-- <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                    <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">
                            16:9
                        </span>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">
                            4:3
                        </span>
                    </label>
                    <label class="btn btn-primary active">
                        <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">
                            1:1
                        </span>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">
                            2:3
                        </span>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: NaN">
                            Free
                        </span>
                    </label>
                </div> -->


                <div class="dropdown dropup docs-options">
                    <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
                        Toggle Options
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="responsive" checked>
                                responsive
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="restore" checked>
                                restore
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="checkCrossOrigin" checked>
                                checkCrossOrigin
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="checkOrientation" checked>
                                checkOrientation
                            </label>
                        </li>

                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="modal" checked>
                                modal
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="guides" checked>
                                guides
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="center" checked>
                                center
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="highlight" checked>
                                highlight
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="background" checked>
                                background
                            </label>
                        </li>

                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="autoCrop" checked>
                                autoCrop
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="movable" checked>
                                movable
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="rotatable" checked>
                                rotatable
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="scalable" checked>
                                scalable
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="zoomable" checked>
                                zoomable
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="zoomOnTouch" checked>
                                zoomOnTouch
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="zoomOnWheel" checked>
                                zoomOnWheel
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="cropBoxMovable" checked>
                                cropBoxMovable
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="cropBoxResizable" checked>
                                cropBoxResizable
                            </label>
                        </li>
                        <li class="form-check" role="presentation">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="toggleDragModeOnDblclick" checked>
                                toggleDragModeOnDblclick
                            </label>
                        </li>
                    </ul>
                </div><!-- /.dropdown -->

                <a class="btn btn-secondary btn-block" data-toggle="tooltip" data-animation="false" href="https://fengyuanchen.github.io/cropperjs" title="Cropper without jQuery">Cropper.js</a>

            </div><!-- /.docs-toggles -->
        </div>


<?php
$this->registerJsFile( BASE_URL . 'backend/plugins/cropper/cropper.js', ['position' => \yii\web\View::POS_END, 'depends' => 'yii\web\JqueryAsset'] );
$this->registerCssFile( BASE_URL . 'backend/plugins/cropper/cropper.min.css', ['position' => \yii\web\View::POS_END] );
$this->registerJsFile( BASE_URL . 'backend/js/cropper-custom.js', ['position' => \yii\web\View::POS_END, 'depends' => 'yii\web\JqueryAsset'] );
?>
<script type="text/javascript"></script>
