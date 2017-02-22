<?php
namespace backend\controllers;

use Yii;

use yii\web\UploadedFile;
use yii\data\Pagination;

use backend\models\MediaFolder as Folder;
use backend\models\MediaFile as File;

/**
 * MediaUploader controller
 */
class MediaUploaderController extends BaseController
{

    public $code  = 'media-uploader';
    
    public $title = 'Media Uploader';
    public $menu  = 'media-uploader';
    public $description = 'Manage your media uploader on this page';
    
    public function actionIndex()
    {   
        $fileQuery  = File::lists()->with('folder');
        $countQuery = clone $fileQuery;
        $filePages  = new Pagination(['totalCount' => $countQuery->count()]);
        $fileDatas  = $fileQuery 
            ->offset( $filePages->offset )
            ->limit(  $filePages->limit  )
            ->all();

        $result = [
            'folderModel' => new Folder(), 
            'folderLists' => Folder::maps( 'id', 'name'),
            'fileModel'   => new File(),
            'fileDatas'   => $fileDatas,
            'filePages'   => $filePages,
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

            $folder = Folder::getDirectory( $post['MediaFile']['media_folder_id'] );
            $model::$uploadFile['name']['path'] = str_replace('media/', '', $folder); // menghapus string "media"

            $file = UploadedFile::getInstance($model,'name');
            $post['MediaFile'][ 'size' ] = $file->size;
            $post['MediaFile'][ 'file_type' ] = $file->type;

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

    public function actionDeleteFile($id)
    {
        $model = File::deleteData(new File(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['media-uploader/index']);
    }
}