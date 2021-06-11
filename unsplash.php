<?php

require './vendor/autoload.php';
// session_start();
Unsplash\HttpClient::init([
	'applicationId'	=> 'WtXaQuUo6QB9xPxsoqwCBLIWm0S1ImqGtDzbluWxlNI',
	'secret'	=> 'WRqMevmuTh_xPpy31SUsI-_-FCtFrkz_2WrHTd5kyVA',
	'callbackUrl'	=> 'https://your-application.com/oauth/callback',
	'utmSource' => ''
]);

// $filters = [
//     'username' => 'andy_brunner',
//     'query'    => 'coffee',
//     'w'        => 100,
//     'h'        => 100
// ];

// $random = Unsplash\Photo::random();
// echo('<pre>');
// var_dump($random);
// echo('<pre>');
// echo '<br>------------<br>';

// echo $random->parameters;
// var_dump($random->links['html']);
// var_dump($random->id);

//型確認
// echo '<br><br>gettype($random)<br>';
// var_dump(gettype($random));

// //オブジェクト型のまま
// echo '<br><br>';
// echo 'get_object_vars($random)<br>';
// var_dump(get_object_vars($random));

// //JSONとして認識すると
// echo '<br><br>';
// echo ' <br>json_decode($random)<br>';
// var_dump( json_decode($random));
// echo '<br>json_decode(json_encode($random), true)<br>';
// $test_json = json_decode(json_encode($random), true);
// var_dump($test_json);

// //配列にしてみる
// echo '<br><br>';
// echo '<br>$test_array = (array)$random<br>';
// $test_array = (array)$random;
// var_dump($test_array);

// echo '<br><br>array_keys($test_array)<br>';
// var_dump(array_keys($test_array));
// echo '<br>$test_array["Unsplash\Endpointparameters"]<br>'; 
// var_dump($test_array["Unsplash\Endpointparameters"]);
// echo '<br>$test_array, 2, 1, true)<br>';
// var_dump(array_slice($test_array, 2, 1, true));
// echo '<br>foreach ($test as $key => $value)<br>';
// foreach ($test as $key => $value) {
//     echo $key;  // $keyにキーの文字が入っている
//     echo "' value is ";
//     var_dump($value);  // $valueにデータが入っている
//     echo "
//    ";
//    }




//試行錯誤その４
// $random =json_decode($random,true);
// echo ($random);
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
// $filters = [
//         'count' => 5,
//         'orientation' =>'portrait',
//         // 'query'    => 'coffee',
//         // 'w'        => 100,
//         // 'h'        => 100
//     ];

// $random = Unsplash\Photo::random($filters);
// var_dump($random->'0');

// echo '<pre>';
// var_dump($random);
// echo '</pre>';
// echo get_object_vars($random);
// foreach ($random as $item) {
// var_dump($item);
// }
// echo '<br>';
// echo '<pre>';
// var_dump($random[0]);
// echo '</pre>';

// echo '<br>------------<br>';
// echo '<pre>';
// var_dump($random[1]);
// echo '</pre>';


// $random2 = Unsplash\Photo::random();
// var_dump($random2->id);
// echo '<br>';
// var_dump($random2->links['html']);
// echo '<br>------------<br>';

// $photos = array();
// $photos[] = Unsplash\Photo::random();
// $photos[] = Unsplash\Photo::random();
// $photos[] = Unsplash\Photo::random();
// $photos[] = Unsplash\Photo::random();
// $photos[] = Unsplash\Photo::random();

// $photo_id_url = array();
// foreach ($photos as $photo) {
//     $photo_id_url[]=[$photo->id,$photo->urls['thumb']];

//     echo '<img src="';
//     echo $photo->urls['thumb'];
//     echo '" width="200">';
// }
// echo '<pre>';
// var_dump($photo_id_url);
// echo '</pre>';
// $all = Unsplash\Photo::all(1, 5, 'popular');
// echo '<pre>';
// var_dump($all);
// echo '<pre>';


$photo_id_url = array();
for($i = 0; $i < 5; $i++){
  $photo = Unsplash\Photo::random();
  $photo_id_url[]=[$photo->id,$photo->urls['thumb']];
  }

echo '<pre>';
var_dump($photo_id_url);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsplash_test</title>
</head>
<body>
    
</body>
</html>