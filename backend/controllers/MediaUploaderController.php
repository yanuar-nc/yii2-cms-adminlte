<?php
namespace backend\controllers;

use Yii;
use backend\models\MediaFolder as Folder;
use backend\models\MediaFile as File;
use yii\web\UploadedFile;

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

    public function actionUploadFile()
    {
        if ( Yii::$app->request->post() )
        {   

            $model = new File();
            
            $post = Yii::$app->request->post();
            $saveModel = File::saveData($model, $post);

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

}