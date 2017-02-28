<?php

namespace common\components;

use yii\base\Component;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Yii;

use common\components\Functions;

class Upload extends Component {

	/**
	 * Function save
	 * Untuk menyimpan file yang akan diupload
	 * Termasuk meresize sebuah image
	 * Bila tidak mensetting @var path maka 
	 * path defaultnya berdasarkan nama table pada model
	 * 
	 * Dan bila ada directorynya maka akan di re-create directory tersebut
	 * @param <mixed>  $model  Model yang digunakan
	 * 
	 * @return void
	 */
	public static function save($model)
	{

		if ( isset($model::$uploadFile) )
		{
			$primaryKey = is_array($model->tableSchema->primaryKey) ? $model->tableSchema->primaryKey[0] : $model->tableSchema->primaryKey;

			$result = [];
			foreach( $model::$uploadFile as $field => $attr )
			{
				$file = UploadedFile::getInstance($model,$field);
				
				if ( !empty( $file ) )
				{
					$path  		= isset($attr['path']) ? $attr['path'] : $model::tableName();
					$directory  = ASSET_PATH . $path . '/' . $model->$primaryKey . '/';
					
					// Set base path
					if ( !file_exists( ASSET_PATH . $path ) ) mkdir(ASSET_PATH . $path);
					
					// Set path directory file
					if ( !file_exists($directory) )
					{
						mkdir($directory);
					} else {
						Functions::removeDir($directory);
						mkdir($directory);
					}

					// Rename using slug
					$fileName = Functions::makeSlug($file->baseName) . '.' . $file->extension;

					// Save file
					$file->saveAs( $directory .  $fileName );

					// Resize file image
					if ( !empty($attr['resize']) )
					{
						foreach ($attr['resize'] as $resize) {
							
							$nameResize = $resize['prefix'] . $fileName;

							$quality = isset($resize['quality']) ? $resize['quality'] : 100;
							Image::thumbnail( 
								$directory . $fileName, 
								$resize['size'][0], 
								$resize['size'][1])
								->save( $directory . $nameResize, ['quality' => $quality] );
						}
					}
					$fieldDirectory = $field . '_dir';
					$model->$field = $fileName;
					$model->$fieldDirectory = $model->$fieldDirectory . $model->$primaryKey . '/';
				} 

			} // Endforeach file upload
			
			$model->save();
			return true;
		}
		return false;

	}


}