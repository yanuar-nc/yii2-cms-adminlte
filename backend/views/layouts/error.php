<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::register($this);

$this->beginPage(); 
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <base href="<?= Yii::$app->homeUrl; ?>">
    </head>

    <body>

    <div class="error-page" style="margin: 7% auto;">
        <div class="lockscreen-logo">
                <a href=""><b><?= $this->params['project']['firstname'] ?></b><?= $this->params['project']['lastname'] ?></a>
        </div>
            <!-- User name -->
            <?= $this->render('/partials/alert') ?>

            <?= $content ?>
            <br>
          <div class="text-center">
                Copyright © 2014-2016 <b><a href="http://yanuarnc.com" class="text-black">Yanuar Nurcahyo</a></b>
                All rights reserved
          </div>
    </div>

    
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
