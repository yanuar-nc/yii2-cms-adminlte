<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\Menu;

/**
 * Menu controller
 */
class MenuController extends BaseController
{

    public $title = 'Menu';
    public $description = 'Sidemenu of CMS.';

    public function actionIndex()
    {
    	return $this->render('index.twig', [ 'lists' => Menu::find()->all() ] );
    }

    public function actionCreate()
    {

    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
    
    /**
     * listOfData function adalah sebuah mandatori untuk 
     * membuat data table dengan serverside
     * 
     * @param HTTP Get
     * 
     * @return     json
     */
    public function actionListOfData()
    {
    	return Menu::getDataForAjax(Yii::$app->request->get());
    }

}