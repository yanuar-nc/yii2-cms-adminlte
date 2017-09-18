<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LoginAsset;

LoginAsset::register($this);
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

    <body class="hold-transition login-page">


    <div class="login-box">
        
        <div class="login-logo">
            <a href="#"><b><?= $this->params['project']['firstname'] ?></b><?= $this->params['project']['lastname'] ?></a>
        </div>

        <?= $this->render( '/partials/alert.php' ) ?>
        <?= $content ?>
    </div>
    
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
