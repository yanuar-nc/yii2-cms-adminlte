<?php

namespace backend\components;

use yii\base\Component;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Yii;

class Upload extends Component {

	/**
	 * Function save
	 * Untuk menyimpan file yang akan diupload
	 * Termasuk meresize sebuah image
	 *
	 * @param <mixed>  $model  Model yang digunakan
	 * 
	 * @return void
	 */
	public static function save($model)
	{

		if ( isset($model::$uploadFile) )
		{
			foreach( $model::$uploadFile as $field => $attr )
			{
				$file = UploadedFile::getInstance($model,$field);
				$directory  = $attr['path'] . $model->tableSchema->primaryKey . '/';
				
				if ( !file_exists($directory) )
				{
					mkdir($directory);
				}
				
				$fileImage = $file->baseName . '.' . $file->extension;
				$file->saveAs( $directory . $fileImage );

				if ( !empty($attr['resize']) )
				{
					foreach ($attr['resize'] as $resize) {
						
						$nameResize = $resize['prefix'] . $fileImage;

						$quality = $resize['quality'] ? $resize['quality'] : 100;

						Image::thumbnail($fileImage, $resize['size'][0], $resize['size'][1])
							->save( $directory . $nameResize, ['quality' => $quality] );
					}
				}

			} // Endforeach file upload
		}

	}

}