<?php
namespace backend\controllers;

use Yii;

use common\services\SettingService;
use backend\components\View;

/**
 * Setting controller
 */
class SettingController extends BaseController
{

    public $title = 'Setting of parameters';
    public $parentMenu  = 'setting';
    public $description = '';
    
    private $setting;

	public function init()
	{
		parent::init();
		$this->setting = new SettingService();
	}    
    
    public function actionIndex()
    {
    	$variables = $this->setting->getAll();
    	return $this->render('index.twig', [ 'variables' => $variables ]);
    }

    public function actionUpdate()
    {
    	$post = Yii::$app->request->post('Setting');
    	if ( !empty($post) )
    	{
    		$this->session->setFlash('success', MSG_DATA_UPDATE_SUCCESS);
    		$this->setting->update($post);
    	}
    	return $this->redirect('index');
    }

    public function actionCreate()
    {
    	$post = Yii::$app->request->post();
    	if ( !empty($post) )
    	{
    		$this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
    		$this->setting->save($post);
    		return $this->redirect('index');
    	}

    	return $this->render('create.twig');
    }

    public function actionDelete($id)
    {
    	$this->setting->delete($id);
    	$this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
		
		return $this->redirect('index');
    }
}