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
    public $menu  = 'menu';
    public $code  = 'menu';
    public $menuChild  = 'mainmenu';
    public $description = 'Sidemenu of CMS.';
    
    public function actionIndex()
    {
    	return $this->render('index.twig', [ 'lists' => Menu::lists()->all() ] );
    }

    /**
     * [actionCreate] 
     * Function ini bisa digunakan untuk CREATE and UPDATE
     * 
     * @param  integer $id [Ini sebagai paramerter data tersebut baru atau tidak, 
     *                      bila baru maka tidak perlu di isi dan data akan di CREATE/INSERT]
     */
    public function actionCreate( $id = null )
    {
        if ($id == null){

            $model = new Menu();

        } else {

            $model = Menu::findOne($id);
            if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        }

        if ( Yii::$app->request->post() )
        {
            $saveModel = Menu::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['menu/index']);

            } else {
                // var_dump($saveModel['message']);exit;
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Menu::formData() ] );
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

    public function actionManagePosition()
    {
        $models = Menu::lists()->orderBy('position')->all();
        if ( Yii::$app->request->post() )
        {
            $post = Yii::$app->request->post('Menu');
            foreach ( $models as $model) {
                $datas['Menu'] = [ 'id' => $model->id, 'position' => $post[$model->id]['position'] ];
                Menu::saveData($model, $datas);
            }
            $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
            // return $this->redirect(['menu/index']);
        }
        
        return $this->render( 'manage-position.twig', [ 'lists' => $models ] );
    }

}