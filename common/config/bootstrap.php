<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

// Define asset path
define( 'ASSET_PATH', dirname(dirname(__DIR__)) . '/media/' );

// Define asset basename
$path = pathinfo(ASSET_PATH);
define( 'ASSET_BASENAME', $path['basename'] );

