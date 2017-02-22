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
        return $this->render('index.twig');
    }

    public function actionAbout()
    {
    	return $this->render('about.twig');
    }
}
