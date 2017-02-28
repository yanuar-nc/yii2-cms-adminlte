<?php
namespace backend\controllers;

use Yii;

use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\components\Functions;

use backend\models\MediaFolder as Folder;
use backend\models\MediaFile as File;

use backend\services\MediaUploaderService as ServiceInstance;

/**
 * MediaUploader controller
 * 
 * Media uploader 
 */
class MediaUploaderController extends BaseController
{

    public $code  = 'media-uploader';
    
    public $title = 'Media Uploader';
    public $menu  = 'media-uploader';
    public $description = 'Manage your media uploader on this page';
    
    public function actionIndex()
    {   
        $fileQuery  = File::getData();
        $countQuery = clone $fileQuery;
        $filePages  = new Pagination(['totalCount' => $countQuery->count()]);
        $fileDatas  = $fileQuery 
            ->offset( $filePages->offset )
            ->limit(  $filePages->limit  )
            ->all();

        $folderData  = Folder::lists()->orderBy('name')->asArray()->all();
        $folderLists = ArrayHelper::map( $folderData, 'id', 'name' );

        $result = [
            'folderModel' => new Folder(), 
            'folderLists' => $folderLists,
            'folderData'  => $folderData,
            'fileModel'   => new File(),
            'fileDatas'   => $fileDatas,
            'filePages'   => $filePages,
        ];

    	return $this->render('index.twig', $result);
    }

    /**
     * Create New Folder
     * 
     * Function ini untuk membuat folder baru
     * dan bila sudah dibuatkan directorynya maka 
     * directory tersebut tidak dapat diedit/dihapus.
     * Dikarenakan (kemungkinan) akan mengganggu 
     * file depedency yang digunakan pada
     * module module lain.
     * 
     * @package     /media/uploader/ 
     * @subpackage  /media/uploader/folder_name
     * 
     * @return     redirect
     */
    public function actionCreateFolder()
    {

        if ( Yii::$app->request->post() )
        {   

            $post = Yii::$app->request->post();
            if ( !empty($post['MediaFolder']['id']) )
            {
                
                $model = Folder::findOne($post['MediaFolder']['id']);     
                
            } else { 

                $model = new Folder(); 
                $slugName = Functions::makeSlug($post['MediaFolder']['name']);
                $post['MediaFolder']['directory'] = ASSET_BASENAME . '/uploader/' . $slugName . '/';
                $newFolder = true;
            }

            $saveModel = Folder::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {

                if ( $newFolder ) 
                {
                    
                    $path = ASSET_PATH . 'uploader/' . $slugName . '/';
                    if ( !file_exists($path)) mkdir( $path );

                }

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
            
            $post = ServiceInstance::filterDataUpload($model);
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

    public function actionDeleteFolder($id)
    {
        $model = Folder::deleteData(new Folder(), $id);

        if ( $model['status'] == true  )
        {
            $this->session->setFlash('success', MSG_DATA_DELETE_SUCCESS);
        } else {
            $this->session->setFlash('danger', $model['message']);
        }
        return $this->redirect(['media-uploader/index']);
    }

    public function actionAjaxGetFolders()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Folder::lists()->select('id, name')->orderBy('name')->asArray()->all();
        return $data;
    }

    public function actionAjaxGetFiles()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        
        $query = File::getData();

        if ( isset( $_GET['folder_id'] ) && $_GET['folder_id'] > 0 ) 
        {
            $query = $query->andWhere([ '=', 'media_folder_id', $_GET['folder_id'] ]);
        }

        $countQuery = clone $query;
        $files = $query
            ->offset($offset)
            ->limit(12)
            ->all();
        $result['count']  = (int) $countQuery->count();
        $result['offset'] = $offset + 12;
        foreach( $files as $file )
        {
            $result['files'][] = [
                'name' => $file->name,
                'path' => $file->folder->directory . $file->id . '/',
                'fullPath' => Yii::$app->params['baseUrl'] . '/' . $file->folder->directory . $file->id . '/',
            ];
        }

        return $result;
    }

    public function actionAjaxUploadFile()
    {

        $model = new File();
        
        $post = ServiceInstance::filterDataUpload($model);
        $saveModel = File::saveData($model, $post);

        if ($saveModel['status'] == true)
        {
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $saveModel;
    }
}