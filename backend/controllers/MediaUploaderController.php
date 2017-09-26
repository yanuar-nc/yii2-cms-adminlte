<?php
namespace backend\controllers;

use Yii;

use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use common\components\Functions;
use common\components\Upload;

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

    public $title = 'Media Uploader';
    public $parentMenu  = 'media-uploader';
    public $description = 'Manage your media uploader on this page';


    public function beforeAction($action)
    {      
        if ($this->action->id == 'ajax-upload-file') {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);

    }


    public function actionIndex($folderId = null)
    {   

        $fileQuery  = File::getData();
        if ( $folderId !== null )
        {
            $fileQuery = $fileQuery->andWhere(['media_folder_id' => $folderId]);
        }
        $countQuery = clone $fileQuery;
        $filePages  = new Pagination(['totalCount' => $countQuery->count()]);
        $fileDatas  = $fileQuery 
            ->offset( $filePages->offset )
            ->limit(  $filePages->limit  )
            ->all();

        $folderData  = Folder::fetch()->orderBy('name')->all();
        $folderLists = ArrayHelper::map( $folderData, 'id', 'name' );

        $result = [
            'folderModel' => new Folder(), 
            'folderLists' => $folderLists,
            'folderData'  => $folderData,
            'fileModel'   => new File(),
            'fileDatas'   => $fileDatas,
            'filePages'   => $filePages,
        ];

        return $this->render('index', $result);
    }

    public function actionSetting($type, $id)
    {
        $model = File::fetch()->andWhere(['id' => $id])->with('folder')->one();
        $folder = $model->folder;

        if ( Yii::$app->request->isPost )
        {
            $post = Yii::$app->request->post();
            $dir = ASSETS_PATH . '../' . $folder->directory . $model->id . '/';

            $original = $dir . $model->name;
            if ( $type == 'medium' )
            {
                Upload::resizeManually( $original, $dir . 'medium_' . $model->name, $post, [$folder->medium_width,$folder->medium_height] );
            } else {
                Upload::resizeManually( $original, $dir . 'thumb_' . $model->name, $post, [$folder->thumbnail_width,$folder->thumbnail_height] );
            }
            $model->updated_by = $this->user->id;
            $model->updated_at = strtotime('now');
            $model->save();

            $this->session->setFlash('success', MSG_DATA_UPDATE_SUCCESS);
            return $this->redirect(['media-uploader/index']);
        }

        $ratio = $type == 'medium' ? $folder->medium_width / $folder->medium_height : $folder->thumbnail_width / $folder->thumbnail_height;

        return $this->render('crop', ['file' => $model, 'folder' => $folder, 'image' => BASE_URL . $folder->directory . $model->id . '/' . 'medium_' . $model->name, 'ratio' => $ratio]);
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
                $newFolder = false;
                
            } else { 

                $model = new Folder(); 
                $slugName = Functions::makeSlug($post['MediaFolder']['name']);
                $post['MediaFolder']['directory'] = 'media/uploader/' . $slugName . '/';
                $newFolder = true;
            }

            $saveModel = Folder::saveData($model, $post);

            if ( $saveModel[ 'status' ] == true )
            {

                if ( $newFolder ) 
                {
                    
                    $path = ASSETS_PATH . 'uploader/' . $slugName . '/';
                    if ( !file_exists($path)) mkdir( $path , 0777 ,true);

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
        $file = File::fetch()->with('folder')->andWhere(['id' => $id])->one();
        $directory = ASSETS_PATH . '../' .$file->folder->directory . $file->id . '/';
        $model = File::deleteData(new File(), $id, true);

        if ( $model['status'] == true  )
        {
            Functions::removeDir($directory);
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
        $data = Folder::fetch()->select('id, name')->orderBy('name')->asArray()->all();
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
            $dir = BASE_URL . $file->folder->directory . $file->id . '/';
            $data = [
                'title'    => $file->title,
                'original' => $dir . $file->name,
                'medium'   => $dir . 'medium_' . $file->name,
                'thumb'    => $dir . 'thumb_' . $file->name,
            ];

            // $result[] = [
            //     'image' => $dir . $file->name,
            //     'thumb' => $dir . 'thumb_' . $file->name,
            //     'folder' => $file->folder->name,
            //     'data'
            // ];

            $result['files'][] = [
                'thumb' => $dir . 'thumb_' . $file->name,
                'data' => json_encode($data)
            ];
        }

        return $result;
    }

    public function actionAjaxCkeditorImage()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $query = File::getData();

        $countQuery = clone $query;
        $files = $query
            ->with('folder')
            ->all();
        foreach( $files as $file )
        {
            $result[] = [
                'image' => BASE_URL . '/' . $file->folder->directory . $file->id . '/' . $file->name,
                'thumb' => BASE_URL . '/' . $file->folder->directory . $file->id . '/thumb_' . $file->name,
                'folder' => $file->folder->name
            ];
        }

        return $result;
    }

    public function actionAjaxUploadFile()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new File();
        
        $post = ServiceInstance::filterDataUpload($model);
        $saveModel = File::saveData($model, $post);
        if ($saveModel['status'] == true)
        {
            $image = File::fetch()->andWhere([ '=', 'id', $saveModel['id'] ])->with('folder')->one();
            $dir   = $image->folder->directory . $image->id . '/';
            $dir = BASE_URL . $image->folder->directory . $image->id . '/';
            $data = [
                'title'    => $image->title,
                'original' => $dir . $image->name,
                'medium'   => $dir . 'medium_' . $image->name,
                'thumb'    => $dir . 'thumb_' . $image->name,
            ];
            return [ 
                'status' => true,
                'thumb' => $dir . 'thumb_' . $image->name,
                'data' => json_encode($data)
            ];
        }
        return $saveModel;
    }
}