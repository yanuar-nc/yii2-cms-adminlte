<?php

namespace frontend\services;

use Yii,
	yii\web\HttpException;

use common\services\SettingService,
	Facebook\Exceptions\FacebookResponseException,
	Facebook\Exceptions\FacebookSDKException,
	Facebook\Facebook;

/**
 * Class for facebook service.
 * 
 * Note: Function - function didalam ini dapat digunakan pada facebook SDK 5.0
 * 
 * @method 		login()
 * @method 		callback()
 * @method 		getUser()
 * 
 * @since  		March 2017
 */
class FacebookService
{
	
	/** @var 	object  	konfigurasi facebook */
	private $facebook;


	/**
	 * construct
	 * 
	 * This function is contain configuration of Facebook OAuth2
	 */
	public function __construct()
	{
		$setting = new SettingService;

		$this->facebook = new Facebook( [ 
			'app_id' => $setting->getValue( 'facebookId' ),
			'app_secret' => $setting->getValue( 'facebookAppSecret' ),
			'default_graph_version' => 'v2.5'
		] );

	}


	/**
	 * Function Login
	 * 
	 * @example: 
	 * $fb = new \common\services\FacebookService();
	 * $fbLoginUrl = $fb->login();
	 * 
	 * @return     login url 
	 */
	public function login()
	{
		$helper 	 = $this->facebook->getRedirectLoginHelper();
		$permissions = ['email', 'user_likes']; // optional
		$loginUrl 	 = $helper->getLoginUrl( BASE_URL . 'facebook/login/callback', $permissions);

		return $loginUrl;
	}


	/**
	 * Callback function
	 * 
	 * Callback ini berasal dari setelah user melakukan login
	 * Lalu menerima token dari facebook dan dimasukan kedalam session
	 * 
	 * Yii::$app->session['facebook_access_token']
	 *  
	 * @throws     \yii\web\HttpException
	 *
	 * @return void
	 */
	public function callback()
	{
		$session = Yii::$app->session;
		$fb = $this->facebook;

		$helper = $fb->getRedirectLoginHelper();
		$session['FBRLH_state'] = $_GET['state'];

		try {
	
		  $accessToken = $helper->getAccessToken();
	
		} catch(FacebookResponseException $e) {
	
		  // When Graph returns an error
		  throw new HttpException(400, 'Graph returned an error: ' . $e->getMessage());

		} catch(FacebookSDKException $e) {
	
		  // When validation fails or other local issues
		  throw new HttpException(400, 'Facebook SDK returned an error: ' . $e->getMessage());
	
		}
		if ( isset($accessToken) ) {
		  // Logged in!
		  $session['facebook_access_token'] = (string) $accessToken;

		  // Now you can redirect to another page and use the
		  // access token from Yii::$app->session['facebook_access_token']
		}

	}


	/**
	 * Gets the user.
	 * 
	 * Untuk mendapatkan data user harus menggunakan access token (Yii::$app->session['facebook_access_token'])
	 * yang berasal dari facebook
	 * 
	 * @throws     \yii\web\HttpException  (description)
	 *
	 * @return     object                  The user.
	 */
	public function getUser()
	{

		$session = Yii::$app->session;
		$fb = $this->facebook;

		if ( !isset($session['facebook_access_token']) )
		{
			throw new HttpException(401, 'You have no authorized');
		}

		// Sets the default fallback access token so we don't have to pass it to each request
		$fb->setDefaultAccessToken($session['facebook_access_token']);

		try {

		  $response = $fb->get('/me?locale=en_US&fields=name,email,gender');
		  return $response->getGraphUser();
		   
		} catch(FacebookResponseException $e) {

		  // When Graph returns an error
		  throw new HttpException(400, 'Graph returned an error: ' . $e->getMessage());

		} catch(FacebookSDKException $e) {

		  // When validation fails or other local issues
		  throw new HttpException(400, 'Facebook SDK returned an error: ' . $e->getMessage());
		}

	}
}