<?php

define( 'ASSETS_PATH', dirname(dirname(__DIR__)) . '/media/' );

define( 'STATIC_FILE', dirname(dirname(__DIR__)) . '/common/config/static.json' );

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');

require(__DIR__ . '/extensions/library.php');
