<?php
namespace backend\controllers;

use Yii;
use backend\models\MediaFolder as Folder;
use backend\models\MediaFile as File;
/**
 * Menu controller
 */
class MediaUploaderController extends BaseController
{

    public $code  = 'media-uploader';
    
    public $title = 'Media Uploader';
    public $menu  = 'media-uploader';
    public $description = 'Manage your media uploader on this page';
    
    public function actionIndex()
    {   

        $result = [
            'folderModel' => new Folder(), 
            'folderLists' => Folder::maps( 'id', 'name'),
            'fileModel'   => new File(),
        ];

    	return $this->render('index.twig', $result);
    }

    public function actionCreateFolder()
    {
        if ( Yii::$app->request->post() )
        {   

            $model = new Folder();
            
            $post = Yii::$app->request->post();
            $saveModel = Folder::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['media-uploader/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->redirect(['media-uploader/index']);
    }

    public function actionCreate($id = null)
    {
        if ($id == null){

            $model = new Tag();

        } else {

            $model = Tag::findOne($id);
            if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        }

        if ( Yii::$app->request->post() )
        {
            
            $post = Yii::$app->request->post();
            $saveModel = Tag::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {
                
                $this->session->setFlash('success', MSG_DATA_SAVE_SUCCESS);
                return $this->redirect(['tag/index']);
            } else {
                $this->session->setFlash('danger', $saveModel['message']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Tag::formData() ] );
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

        $model = Tag::findOne($id);

        if ( empty( $model ) ) throw new \yii\web\HttpException(404, MSG_DATA_NOT_FOUND);

        if ( Yii::$app->request->post() )
        {

            $saveModel = Tag::saveData($model, Yii::$app->request->post());
            if ( $saveModel[ 'status' ] == true )
            {
                $this->session->setFlash('success', MSG_DATA_EDIT_SUCCESS);
                return $this->redirect(['tag/index']);
            }
        }
        return $this->render( '/templates/form.twig', [ 'model' => $model, 'fields' => Tag::formData() ] );
    }

    public function actionDelete($id)
    {

        $model = Tag::deleteData(new Tag(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['tag/index']);
    }

}