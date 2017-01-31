<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use backend\models\Page;

/**
 * Menu controller
 */
class PageController extends BaseController
{

    public $title = 'Page';
    public $description = 'Manage yourpage on this page';

    public function actionIndex()
    {
        // foreach (Page::find()->with('user')->all() as $val) {
        //     echo $val::$getStatus[$val['row_status']];
        // }
        // exit;
    	return $this->render('index.twig', [ 'lists' => Page::find()->with('user')->all() ] );
    }

    public function actionCreate()
    {
        $model = new Page();

        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Page::formData() ] );
    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
    
    public function actionListOfData()
    {
    	return Page::getDataForAjax(Yii::$app->request->get());
    }

}