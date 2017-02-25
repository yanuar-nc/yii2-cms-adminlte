<?php
 
namespace backend\services;

use Yii;

use yii\web\UploadedFile;

use backend\models\MediaFolder as Folder;


class MediaUploaderService 
{


	public static function filterDataUpload($model)
	{
        $post = Yii::$app->request->post();

        $folder = Folder::getDirectory( $post['MediaFile']['media_folder_id'] );
        $model::$uploadFile['name']['path'] = str_replace('media/', '', $folder); // menghapus string "media"

        $file = UploadedFile::getInstance($model,'name');
        if ( empty($file) )
        {
        	throw new \yii\web\HttpException(400, 'The requested Item could not be found.');
        }

        $post['MediaFile'][ 'size' ] = $file->size;
        $post['MediaFile'][ 'file_type' ] = $file->type;
        
		return $post;
	}
}