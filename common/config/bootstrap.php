<?php

<<<<<<< HEAD
define( 'ASSETS_PATH', dirname(dirname(__DIR__)) . '/media/' );

define( 'STATIC_FILE', dirname(dirname(__DIR__)) . '/common/config/static.json' );

=======
>>>>>>> 4fcaf81c6640d7d4aca4501f2dc7763657b5a3ce
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
<<<<<<< HEAD
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');

require(__DIR__ . '/extensions/library.php');
=======

// Define asset path
define( 'ASSET_PATH', dirname(dirname(__DIR__)) . '/media/' );

// Define asset basename
$path = pathinfo(ASSET_PATH);
define( 'ASSET_BASENAME', $path['basename'] );

>>>>>>> 4fcaf81c6640d7d4aca4501f2dc7763657b5a3ce
