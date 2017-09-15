<?php
use backend\assets\DashboardAsset;

DashboardAsset::register($this);
?>
<!-- Button trigger modal -->


<div class="row">
    
    <div class="col-md-3 col-sm-6 col-xs-12">
      	<div class="info-box">
        <span class="info-box-icon bg-purple"><i class="fa fa-envelope-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Messages</span>
          <span class="info-box-number">1,410</span>
        </div>
        <!-- /.info-box-content -->
      	</div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    
    <div class="col-md-3 col-sm-6 col-xs-12">
      	<div class="info-box">
	        <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

	        <div class="info-box-content">
		          <span class="info-box-text">Bookmarks</span>
		          <span class="info-box-number">410</span>
	        </div>
	        <!-- /.info-box-content -->
      	</div>
      <!-- /.info-box -->
    </div>

    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
	      <div class="info-box">
		        <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>

		        <div class="info-box-content">
			          <span class="info-box-text">Uploads</span>
			          <span class="info-box-number">13,648</span>
		        </div>
		        <!-- /.info-box-content -->
	      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
	      <div class="info-box">
	        <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

	        <div class="info-box-content">
		          <span class="info-box-text">Likes</span>
		          <span class="info-box-number">93,139</span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">

	<div class="col-md-9">
	<!-- solid sales graph -->
      	<div class="box box-solid bg-teal disabled">
	        <div class="box-header">
		        <i class="fa fa-area-chart"></i>

	            <h3 class="box-title">Graphinfo Today</h3>

		        <div class="box-tools pull-right">
		            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
		            </button>
		            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
		            </button>
		        </div>
	        </div>
	        <div class="box-body border-radius-none">
		          <div class="chart" id="line-chart" style="height: 400px;"></div>
	        </div>
	        <!-- /.box-body -->
	        <div class="box-footer no-border">
	        	<div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="<?= $registerToday ?>" data-width="60" data-height="60" data-fgColor="#39CCCC">

                  <div class="knob-label">Register</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="<?= $isOnline ?>" data-width="60" data-height="60" data-fgColor="#39CCCC">

                  <div class="knob-label">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="<?= $messageToday ?>" data-width="60" data-height="60" data-fgColor="#39CCCC">

                  <div class="knob-label">Message</div>
                </div>
                <!-- ./col -->
              </div>
	        </div>
	        <!-- /.box-footer -->
      	</div>
	</div>
    <!-- /.box -->

    <div class="col-md-3">
		<div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-envelope-o"></i>

              <h3 class="box-title">Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>
            <!-- /.box-body -->
    </div>
		<div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-file-image-o"></i>

              <h3 class="box-title">Our Gallery</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="http://placehold.it/900x500/3e34d4/ffffff&text=I+Love+Bootstrap" alt="First slide">

                    <div class="carousel-caption">
                      First Slide
                    </div>
                  </div>
                  <div class="item">
                    <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">

                    <div class="carousel-caption">
                      Second Slide
                    </div>
                  </div>
                  <div class="item">
                    <img src="http://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">

                    <div class="carousel-caption">
                      Third Slide
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>

            </div>
            <!-- /.box-body -->
    </div>
</div>

<?php
$js = <<<JS
var line = new Morris.Line({
	element: 'line-chart',
	resize: true,
	data: JSON.parse('$visitorGraph') ,
	parseTime: false,
	xkey: 'date',
	ykeys: ['item1'],
	labels: ['Visitor'],
	lineColors: ['#efefef'],
	lineWidth: 2,
	hideHover: 'auto',
	gridTextColor: "#fff",
	gridStrokeWidth: 0.4,
	pointSize: 4,
	pointStrokeColors: ["#efefef"],
	gridLineColor: "#efefef",
	gridTextFamily: "Open Sans",
	gridTextSize: 10
});
JS;

echo $this->registerJs( $js );
?>