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

			foreach( $model::$uploadFile as $field => $attr )
			{
				$file = UploadedFile::getInstance($model,$field);
				$directory  = ASSETS_PATH . $attr['path'] . $model->$primaryKey . '/';

				if ( !file_exists($directory) )
				{
					mkdir($directory);
				} else {
					static::removeDir($directory);
					mkdir($directory);
				}
				
				$fileImage = Functions::makeSlug($file->baseName) . '.' . $file->extension;
				$file->saveAs( $directory .  $fileImage );

				if ( !empty($attr['resize']) )
				{
					foreach ($attr['resize'] as $resize) {
						
						$nameResize = $resize['prefix'] . $fileImage;

						$quality = isset($resize['quality']) ? $resize['quality'] : 100;

						Image::thumbnail( $directory . $fileImage, $resize['size'][0], $resize['size'][1])
							->save( $directory . $nameResize, ['quality' => $quality] );
					}
				}

			} // Endforeach file upload
			
			return true;
		}
		return false;

	}

	/**
	 * Removes a dir.
	 * function ini untuk menghapus directory bersama recursive/turunannya
	 * 
	 * @param      string  $dir    Directory
	 * @return true
	 */
	public static function removeDir($dir) 
	{ 
	   	if (is_dir($dir)) 
	   	{ 

			$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") 
				{ 
					if (is_dir($dir."/".$object))
						rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object); 
				} 
			}
	     	rmdir($dir);

	   	} 

	   	return true;
	}

}