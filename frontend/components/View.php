<?php

namespace frontend\components;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\services\SettingService;


/**
 *
 * These functions used by /frontend/views/layouts/main.twig 

 */
class View extends \yii\web\View
{

	public $meta,
		   $title,
		   $service,
		   $instagramUrl,
		   $facebookUrl,
		   $twitterUrl;

	public function __construct()
	{
		parent::__construct();

		$this->service = new SettingService;

	}

	public function meta()
	{
		$service = $this->service;

		$this->instagramUrl = $service->getValue('instagram');
		$this->twitterUrl 	= $service->getValue('twitter');
		$this->facebookUrl 	= $service->getValue('facebook');

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

	public function googleAnalytic()
	{
		$trackingId = $this->service->getValue('gaTrackingId');

		if ( $trackingId === 'Variable is not defined' || empty($trackingId) )
		{
			return null;
		} 
		
		return "<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

				  ga('create', '" . $trackingId . "', 'auto');
				  ga('send', 'pageview');

				</script>";
	}
}