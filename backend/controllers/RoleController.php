<?php
namespace backend\controllers;

use Yii;
use backend\models\Role,
    backend\models\Action,
    backend\models\Menu,
    backend\models\RoleMenu;

use yii\helpers\StringHelper, yii\helpers\ArrayHelper;

/**
 * Menu controller
 */
class RoleController extends BaseController
{

    public $code  = 'role';
    
    public $title = 'Role';
    public $menu  = 'role';
    public $menuChild  = 'role';
    public $description = 'Manage your role on this page';
    
    public function actionIndex()
    {
    	return $this->render('/templates/ajax-list.twig', [ 'headers' => Role::getHeader() ]);
    }

    public function actionCreate($id = null)
    {
        if ($id == null){

            $model = new Role();

        } else {

            $model = Role::findOne($id);
            if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        }

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = Role::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['role/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Role::formData() ] );
    }

    /**
     * { function_description }
     *
     * @param      <int>                          $id     The identifier
     *
     * @throws     \yii\web\NotFoundHttpException  (Jika tidak ada satupun data yang ditemukan,
     *                                              maka akan dilempar ke halaman not found)
     *
     */
    public function actionUpdate($id)
    {

        $model = Role::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = Role::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['role/index']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Role::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = Role::deleteData(new Role(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['role/index']);
    }
    

    public function actionSetPermission($id)
    {

        $menus = Menu::fetch()->asArray()->all();
        $actions = Action::fetch()->asArray()->all();

        $req = Yii::$app->request;
        if( $req->isPost )
        {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();

            $model = new RoleMenu;
            $post = $req->post('Permission');

            try {

                RoleMenu::deleteAll('role_id = ' . $id);

                $result = [];

                foreach( $post['action'] as $menu => $actions )
                {

                    foreach ($actions as $action) {
                        $connection->createCommand("INSERT INTO `role_menu` (`id`, 
                                                                             `role_id`, 
                                                                             `menu_id`, 
                                                                             `action_id`, 
                                                                             `row_status`, 
                                                                             `created_at`, 
                                                                             `created_by`, 
                                                                             `updated_by`, 
                                                                             `updated_at`) VALUES 
                                                                            (NULL, 
                                                                            '{$id}', 
                                                                            '{$menu}', 
                                                                            '{$action}', 
                                                                            1, 
                                                                            '".strtotime('now')."', 
                                                                            '".Yii::$app->user->identity['id']."', 
                                                                            NULL, 
                                                                            ".strtotime('now').");
                        ")->execute();
                    }
                }
                $transaction->commit();

                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['role/set-permission', 'id' => $id]);

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

        } else {

            $menuSelected = [];
            $allRoleMenu = RoleMenu::find()->andWhere(['role_id' => $id])->asArray()->all();
            $menus   = ArrayHelper::index($menus, 'id');
            $actions = ArrayHelper::index($actions, 'id');
            foreach ($allRoleMenu as $armenu) {

                $menuSelected[$armenu['menu_id']]['actions'][$armenu['action_id']]['selected']  = true;
                $menuSelected[$armenu['menu_id']]['selected'] = true;
            }

        }

        return $this->render( 'set-permission.twig', [ 'menus' => $menus, 'actions' => $actions, 'menuSelected' => $menuSelected ] );
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
        return Role::getDataForAjax(Yii::$app->request->get());
    }

}