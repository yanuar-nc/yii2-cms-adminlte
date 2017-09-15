<?php
 
namespace backend\services;

use Yii;

use yii\web\UploadedFile;

use backend\models\MediaFolder as Folder;

use yii\helpers\ArrayHelper;

class MediaUploaderService 
{

	public static function filterDataUpload($model)
	{
                $post = Yii::$app->request->post();

                $folder = Folder::fetchOne( $post['MediaFile']['media_folder_id'] );
                $model::$uploadFile['name']['path'] = str_replace('media/', '', $folder->directory); // menghapus string "media"
                $model::$uploadFile['name']['resize'][0]['size'] = [ $folder->thumbnail_width, $folder->thumbnail_height ];
                $model::$uploadFile['name']['resize'][1]['size'] = [ $folder->medium_width, $folder->medium_height ];
                // $reindex = ArrayHelper::index($model::$uploadFile['name']['resize'], 'prefix');
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