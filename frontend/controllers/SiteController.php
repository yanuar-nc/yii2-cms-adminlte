<?php
namespace frontend\controllers;
use Yii;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $OAUTH2_CLIENT_ID = '209886918070-0jtj7a4l4bk2fltp41e188os5urj9m94.apps.googleusercontent.com';
        $OAUTH2_CLIENT_SECRET = '0ZJCYIB7x-Qt7cOq25zRrNin';

        $client = new \Google_Client();
        $client->setClientId($OAUTH2_CLIENT_ID);
        $client->setClientSecret($OAUTH2_CLIENT_SECRET);
        $client->setScopes('https://www.googleapis.com/auth/youtube');
        $redirect = 'http://yii2-lte.dev';
        $client->setRedirectUri($redirect);

        // Define an object that will be used to make all API requests.
        $youtube = new \Google_Service_YouTube($client);

if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken()) {
  try{

    // REPLACE this value with the video ID of the video being updated.
    $videoId = "VIDEO_ID";

    // REPLACE this value with the path to the image file you are uploading.
    $imagePath = "/path/to/file.png";

    // Specify the size of each chunk of data, in bytes. Set a higher value for
    // reliable connection as fewer chunks lead to faster uploads. Set a lower
    // value for better recovery on less reliable connections.
    $chunkSizeBytes = 1 * 1024 * 1024;

    // Setting the defer flag to true tells the client to return a request which can be called
    // with ->execute(); instead of making the API call immediately.
    $client->setDefer(true);

    // Create a request for the API's thumbnails.set method to upload the image and associate
    // it with the appropriate video.
    $setRequest = $youtube->thumbnails->set($videoId);

    // Create a MediaFileUpload object for resumable uploads.
    $media = new Google_Http_MediaFileUpload(
        $client,
        $setRequest,
        'image/png',
        null,
        true,
        $chunkSizeBytes
    );
    $media->setFileSize(filesize($imagePath));


    // Read the media file and upload it chunk by chunk.
    $status = false;
    $handle = fopen($imagePath, "rb");
    while (!$status && !feof($handle)) {
      $chunk = fread($handle, $chunkSizeBytes);
      $status = $media->nextChunk($chunk);
    }

    fclose($handle);

    // If you want to make other calls after the file upload, set setDefer back to false
    $client->setDefer(false);


    $thumbnailUrl = $status['items'][0]['default']['url'];
    $htmlBody .= "<h3>Thumbnail Uploaded</h3><ul>";
    $htmlBody .= sprintf('<li>%s (%s)</li>',
        $videoId,
        $thumbnailUrl);
    $htmlBody .= sprintf('<img src="%s">', $thumbnailUrl);
    $htmlBody .= '</ul>';


    } catch (Google_Service_Exception $e) {
      $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
          htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
      $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
          htmlspecialchars($e->getMessage()));
    }

    $_SESSION['token'] = $client->getAccessToken();
    } else {
      // If the user hasn't authorized the app, initiate the OAuth flow
      $state = mt_rand();
      $client->setState($state);
      $_SESSION['state'] = $state;

      $authUrl = $client->createAuthUrl();
      $htmlBody = '<h3>Authorization Required</h3>
        <p>You need to <a href="'.$authUrl.'">authorize access</a> before proceeding.<p>';
    }
        echo $htmlBody;
        exit;
        return $this->render('index.twig');
    }

    public function actionAbout()
    {
    	return $this->render('about.twig');
    }
}
