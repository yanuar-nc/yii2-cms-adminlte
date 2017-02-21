<?php
namespace frontend\controllers;

use Yii;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index.php');
    }

    public function actionAbout()
    {
    	return 'about';
    }
}
