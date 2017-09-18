
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">

            <div class="pull-left image">
                <img src="<?= $this->params['user']['image'] ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $this->params['user']['fullname'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?= $this->params['user']['role'] ?></a>
            </div>
        </div>
        
        <!-- search form -->
        <form action="#" class="sidebar-form" onsubmit="javascript: return false;">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..." id="search__menu">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                    </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>


<?php 
                
                $params = $this->params;
                // echo "<pre>";
                // var_dump( $params['menus'] );
                // exit;
                foreach( $params['menus'] as $controller => $menu ):
                    
                    $class = '';
                    if ( $params['parentMenu'] == $controller ) {
                        $class = 'active';
                    }

                    if ( !empty($menu['submenu']) ) {
?>
                        
                        <li class="treeview <?= $class ?>">
                            <a href="#">
                                <i class="<? $menu['icon'] ?>"></i> <span><?= $menu['name'] ?></span>
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                            </a>

                            <ul class="treeview-menu">

                                <?php 

                                    foreach ( $menu['submenu'] as $subCtrl => $submenu ):

                                        $classChild = Yii::$app->controller->id == $subCtrl ? 'active' : null;
                                ?>
                                    <li class="<?= $classChild ?>">
                                        <a href="<?= $submenu['route'] ?>"><i class="fa fa-circle-o"></i> 
                                            <span><?= $submenu['name'] ?></span>
                                        </a>
                                    </li>
                                <?php endforeach ; ?>

                            </ul>
                        </li>
<?php
                    } else {
?>
                        <li class="<?= $class ?>"><a href="<?= $menu['route'] ?>"><i class="<?= $menu['icon'] ?>"></i> <span><?=  $menu['name'] ?></span></a></li>
<?php
                    }

                endforeach;

?>

        </ul>
        
    </section>
    <!-- /.sidebar -->
</aside>

<?php
$js = '
    $("#search__menu").on("keyup", function(){

        var value = $(this).val().toLowerCase();
        $(".sidebar-menu > li").each(function(index){

            if ( index !== 0 )
            {
                $list = $(this);

                var id = $list.find("a:first").text().toLowerCase();
                if ( id.indexOf(value) <= 0 && value.length != 0 )
                {
                    $list.hide();
                } else {
                    $list.show();
                }
            }

        });
    });';

echo $this->registerJs($js);
