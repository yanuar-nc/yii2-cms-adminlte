<?php

/**
 * FRONTEND routes
 * 
 * @used_by 		/frontend/config/main.php
 * 
 * @filesource 		/frontend/config/routes.php
 * 
 */
return [

    'home' => 'site/index',

    'product' => 'site/product',
    'product/<slug:[0-9a-zA-Z\-]+>' => 'site/product-detail',
    
    'article' => 'article/index',
    'article/<slug:[0-9a-zA-Z\-]+>' => 'article/category',
    'article/<category:[0-9a-zA-Z\-]+>/<slug:[0-9a-zA-Z\-]+>' => 'article/detail',

    '<controller:[0-9a-zA-Z\-]+>/<id:\d+>' => '<controller>/view',
    '<controller:[0-9a-zA-Z\-]+>/<action:[0-9a-zA-Z\-]+>/<id:\d+>' => '<controller>/<action>',
    '<controller:[0-9a-zA-Z\-]+>/<action:[0-9a-zA-Z\-]+>' => '<controller>/<action>',

];