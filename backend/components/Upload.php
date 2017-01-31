<?php

namespace backend\components;

use yii\base\Component;
use yii\web\UploadedFile;
use Yii;

class Upload extends Component {

	public static function save($model)
	{
		$file = UploadedFile::getInstance($model,'image');
		$file->saveAs($file->baseName . '.' . $file->extension);
		// $model->upload();
	}
}