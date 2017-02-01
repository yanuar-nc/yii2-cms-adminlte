<?php

namespace backend\components;

use yii\base\Component;
use yii\web\UploadedFile;
use Yii;

class Upload extends Component {

	public static function save($model, $field)
	{
		$file = UploadedFile::getInstance($model,$field);
		$directory  = $model::${$field.'Path'} . $model->id . '/';
		
		if ( !file_exists($directory) )
		{
			mkdir($directory);
		}

		$file->saveAs( $directory . $file->baseName . '.' . $file->extension);
		// $model->upload();
	}
}