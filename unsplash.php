<?php

require './vendor/autoload.php';
// session_start();
Unsplash\HttpClient::init([
	'applicationId'	=> 'WtXaQuUo6QB9xPxsoqwCBLIWm0S1ImqGtDzbluWxlNI',
	'secret'	=> 'WRqMevmuTh_xPpy31SUsI-_-FCtFrkz_2WrHTd5kyVA',
	'callbackUrl'	=> 'https://your-application.com/oauth/callback',
	// 'utmSource' => 'NAME OF YOUR APPLICATION'
]);

$filters = [
    'username' => 'andy_brunner',
    'query'    => 'coffee',
    'w'        => 100,
    'h'        => 100
];
$random = Unsplash\Photo::random($filters);

$test = (array)$random;
// var_dump(array_keys($test));
// echo '<br>';
// var_dump($test["Unsplash\Endpointparameters"]);
// 連想配列のキーと値を出力
var_dump(array_slice($test, 2, 1, true));

// foreach ($test as $key => $value) {
//     echo $key;  // $keyにキーの文字が入っている
//     echo "'s value is ";
//     var_dump($value);  // $valueにデータが入っている
//     echo "
//    ";
//    }
// echo $test["Unsplash\Endpointparameters"];
// $test = json_decode(json_encode($random), true);
// $random =json_decode($random,true);
// echo ($random);
// var_dump(get_object_vars($random));
// var_dump($random);
// var_dump($random["urls"]);
// // Landing on the page for the first time, setup connection with private application details registered with unsplash and redirect user to authenticate
// if (!isset($_GET['code']) && !isset($_SESSION['token'])) {
//     \Unsplash\HttpClient::init([
//         'applicationId'	=> 'WtXaQuUo6QB9xPxsoqwCBLIWm0S1ImqGtDzbluWxlNI',
//         'secret'		=> 'WRqMevmuTh_xPpy31SUsI-_-FCtFrkz_2WrHTd5kyVA',
//         'callbackUrl'	=> 'http://localhost:8888/Moonlight/unsplash.php'
//     ]);
//     $httpClient = new \Unsplash\HttpClient();
//     $scopes = ['public'];
//     header("Location: ". $httpClient::$connection->getConnectionUrl($scopes));
//     exit;
// }

// Unsplash sends user back with ?code=XXX, use this code to generate AccessToken
// if (isset($_GET['code']) && !isset($_SESSION['token'])) {
//     \Unsplash\HttpClient::init([
//         'applicationId'	=> 'WtXaQuUo6QB9xPxsoqwCBLIWm0S1ImqGtDzbluWxlNI',
//         'secret'		=> 'WRqMevmuTh_xPpy31SUsI-_-FCtFrkz_2WrHTd5kyVA',
//         'callbackUrl'	=> 'http://localhost:8888/Moonlight'
//     ]);

//     try {
//         $token = \Unsplash\HttpClient::$connection->generateToken($_GET['code']);
//     } catch (Exception $e) {
//         print("Failed to generate access token: {$e->getMessage()}");
//         exit;
//     }

    // Store the access token, use this for future requests
    // $_SESSION['token'] = $token;
// }

// Send requests to Unsplash
// \Unsplash\HttpClient::init([
//     'applicationId'	=> 'WtXaQuUo6QB9xPxsoqwCBLIWm0S1ImqGtDzbluWxlNI',
//     'secret'		=> 'WRqMevmuTh_xPpy31SUsI-_-FCtFrkz_2WrHTd5kyVA',
//     'callbackUrl'	=> 'http://localhost:8888/Moonlight/unsplash.php'
// ], [
//     'access_token' => $_SESSION['token']->getToken(),
//     'expires_in' => 30000,
//     'refresh_token' => $_SESSION['token']->getRefreshToken()
// ]);

// $httpClient = new \Unsplash\HttpClient();
// $owner = $httpClient::$connection->getResourceOwner();

// print("Hello {$owner->getName()}, you have authenticated successfully");

// Or apply some optional filters by passing a key value array of filters
// $filters = [
//     'username' => 'andy_brunner',
//     'query'    => 'coffee',
//     'w'        => 100,
//     'h'        => 100
// ];
// \Unsplash\Photo::random($filters);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>