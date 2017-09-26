<?php 
use yii\helpers\Url;
use common\components\Functions;

$user = $this->params['user'];
$project = $this->params['project'];
?>

<header class="main-header">

    <!-- Logo -->
    <a href="{{ url(['site/index']) }}" class="logo">

        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><?= strtoupper(substr($project['firstname'],0,1)); ?></b><?= strtoupper(substr($project['lastname'],0,2)); ?></span>

        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?= $this->params['project']['firstname'] ?></b><?= $this->params['project']['lastname'] ?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <?php
                    $notifications = $this->params['notifications'];
                    $notifCount = count( $notifications );
                ?>
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <?php if ( $notifCount > 0 ): ?>
                            <span class="label label-success"><?= $notifCount ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            You have <?= count( $notifCount ); ?> messages
                        </li>
                        <li>

                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <?php foreach( $notifications as $notification ): ?>
                                <li>
                                <!-- start message -->
                                    <a href="<?= Url::to( [ $notification->link ] ) ?>">
                                        <div class="pull-left">
                                            <img src="img/2-512.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            <?= $notification->title ?>
                                            <small>
                                                <i class="fa fa-clock-o"></i> 
                                                <?= Functions::timeElapsed( $notification->created_at ) ?>
                                            </small>
                                        </h4>
                                        <p><?= substr( $notification->content, 0, 40 ) ?></p>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            <!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Notifications</a></li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $user['image'] ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $user['fullname'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                    <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $user['image'] ?>" class="img-circle" alt="User Image">

                            <p>
                                <?= $user['fullname'] . '-' . $user['position'] ?>
                                <small>Member since <?= $user['created_at'] ?></small>
                            </p>
                        </li>
                      <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="user/change-password" class="btn btn-default btn-flat">Change Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="site/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>