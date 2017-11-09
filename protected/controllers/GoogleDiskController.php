<?php
session_start();
/**
 * @import Google lib for Google Service Drive
 */
Yii::import('application.vendors.*');
require_once (Yii::app()->basePath .'/vendor/GoogleLib/vendor/autoload.php');

class GoogleDiskController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * @param Google Service Drive, Google Client
     * @return array files filters modified for last month
     */
    function getFilesInfo($service, $client) {
        //@var result search files
        $result = array();
        try {
            $startSearchDate = date(DATE_ISO8601, strtotime("-1 months"));
            $parameters = array();
            $parameters['q'] = "modifiedTime > '".$startSearchDate."'";
            $parameters['fields'] = 'nextPageToken, files(id, name, createdTime,modifiedTime)';
            $files = $service->files->listFiles($parameters);
            $result =  $files->files;
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
            $err = json_decode($e->getMessage());

            // if error 401 go to login
            if ($err->error->code==401)
            {
                $authUrl = $client->createAuthUrl();
                header('Location: ' . $authUrl);
                exit();
            }
        }
        return $result;
    }
    /**
     * @login google drive and
     * @return array files info for view
     */
    public function fileInfo()
    {
        $client = new Google_Client();

        // verify for local web server Windows
//        $client->setHttpClient(new \GuzzleHttp\Client(array(
//            'verify' => 'C:\Windows\ca-bundle.crt',
//        )));

        // @var list files info
        $all_files = array();
        $client->setAuthConfig(Yii::app()->basePath .'/vendor/GoogleLib/credentials.json');
        $client->addScope(Google_Service_Drive::DRIVE);

        // Your redirect URI can be any registered URI, but in this example
        // we redirect back to this same page
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] .'/yii/oauth2callback.php');

        if ((isset($_SESSION['access_token']) && $_SESSION['access_token'])) {

            $client->setAccessToken($_SESSION['access_token']);

            $service = new Google_Service_Drive($client);

            $all_files = $this->getFilesInfo($service,$client);
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit();
        }
        return $all_files;
    }
}