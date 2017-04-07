<?php

namespace frontend\components;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\services\SettingService;

class View extends \yii\web\View
{

	public $meta,
		   $title,
		   $instagramUrl,
		   $facebookUrl,
		   $twitterUrl;

	public function __construct()
	{
		parent::__construct();

		$service = new SettingService;

		/** These variables used by /frontend/views/layouts/main.twig */
		$this->instagramUrl = $service->getValue('instagram');
		$this->twitterUrl 	= $service->getValue('twitter');
		$this->facebookUrl 	= $service->getValue('facebook');


	}

	public function meta()
	{
		$service = new SettingService;

		$data = $this->meta;

		$description = isset($data['description']) ? $data['description'] : $service->getValue('meta-description');
		$keywords 	 = isset($data['keywords']) ? $data['keywords'] : $service->getValue('meta-keywords');
		$title 		 = isset($data['title']) ? $data['title'] : $service->getValue('meta-title');
		$image 		 = isset($data['image']) ? $data['image'] : $service->getValue('meta-image');
		$url 		 = isset($data['url']) ? $data['url'] : Url::current(['lg'=>NULL], TRUE);

		$result = '<title>' . Html::encode($title) . '</title>';
		$result .= '<meta name="description" content="'. $description .'">';
		$result .= '<meta name="keywords" 	 content="'. $keywords .'">';
		$result .= '<meta name="robots" 	 content="'. (isset($data['robots']) ? $data['robots'] : 'noindex, follow') . '">';

		$result .= '<meta property="og:title" content="'. $title .'">';
		$result .= '<meta property="og:type"  content="'. (isset($data['og:type']) ? $data['og:type'] : 'article') .'">';
		$result .= '<meta property="og:image" content="'. $image .'">';
		$result .= '<meta property="og:url"   content="'. $url . '">';
		$result .= '<meta property="og:description" content="'. $description . '">';


		$result .= '<meta property="twitter:title" content="'. $title .'">';
		$result .= '<meta property="twitter:card"  content="'. (isset($data['twitter:card']) ? $data['twitter:card'] : 'summary') .'">';
		$result .= '<meta property="twitter:image" content="'. $image .'">';
		$result .= '<meta property="twitter:url"   content="'. $url . '">';
		$result .= '<meta property="twitter:description" content="'. $description . '">';

		return $result;
	}
}