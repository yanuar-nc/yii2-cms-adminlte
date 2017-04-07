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
					$directory  = ASSETS_PATH . $path . '/' . $model->$primaryKey . '/';
					
					// Set base path
					if ( !file_exists( ASSETS_PATH . $path ) ) mkdir(ASSETS_PATH . $path);
					
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
							self::resize( 
								$directory . $fileName, 
								$directory . $nameResize,
								$resize['size'][0], 
								$resize['size'][1],
								100 );
						}
					}
					$model->$field = $fileName;
				} 

			} // Endforeach file upload
			
			$model->save();
			return true;
		}
		return false;

	}

	/**
	 * [resize description]
	 * @param  [string]  $image_original [description]
	 * @param  [string]  $image_resize     [description]
	 * @param  [integer]  $max_width   [description]
	 * @param  [integer]  $max_height  [description]
	 * @param  integer $quality     [description]
	 * @return boolean               [description]
	 */
	public static function resize($image_original, $image_resize, $max_width, $max_height, $quality = 80){
	    $imgsize = getimagesize($image_original);
	    $width = $imgsize[0];
	    $height = $imgsize[1];
	    $mime = $imgsize['mime'];
	 
	    switch($mime){
	        case 'image/gif':
	            $image_create = "imagecreatefromgif";
	            $image = "imagegif";
	            break;
	 
	        case 'image/png':
	            $image_create = "imagecreatefrompng";
	            $image = "imagepng";
	            $quality = 7;
	            break;
	 
	        case 'image/jpeg':
	            $image_create = "imagecreatefromjpeg";
	            $image = "imagejpeg";
	            $quality = 80;
	            break;
	 
	        default:
	            return false;
	            break;
	    }
	     
	    $dst_img = imagecreatetruecolor($max_width, $max_height);
	    $src_img = $image_create($image_original);

		imagealphablending($dst_img, false);
		imagesavealpha($dst_img, true);

		$trans_layer_overlay = imagecolorallocatealpha($dst_img, 220, 220, 220, 127);
		imagefill($dst_img, 0, 0, $trans_layer_overlay);
		
	    $width_new = $height * $max_width / $max_height;
	    $height_new = $width * $max_height / $max_width;
	    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
	    if($width_new > $width){
	        //cut point by height
	        $h_point = (($height - $height_new) / 2);
	        //copy image
	        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
	    }else{
	        //cut point by width
	        $w_point = (($width - $width_new) / 2);
	        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
	    }
	     
	    $image($dst_img, $image_resize, $quality);
	 
	    if($dst_img)imagedestroy($dst_img);
	    if($src_img)imagedestroy($src_img);

	    return true;
	}
}