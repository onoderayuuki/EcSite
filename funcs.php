<?php
//XSS対応関数
function h($val){
  return htmlspecialchars($val,ENT_QUOTES);
}
function loginCheck(){
  if (!isset($_SESSION["chk_ssid"]) ||$_SESSION["chk_ssid"] != session_id()
  ) {
    echo "LOGIN ERROR";
    echo '<br>';
    echo '<a href="./login.php">Login</a>';
    exit();
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
}
//require
require_once 'vendor/autoload.php';

function createPDO(){
  //for .env
  // use Dotenv\Dotenv;
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load(); //.envが無いとエラーになる
  $dbConfig = 'mysql:dbname='.$_ENV['DB_DATABASE'].';host='.$_ENV['DB_HOST'].';charset=utf8';
    try {
      // $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
      $pdo = new PDO($dbConfig, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
      return $pdo; 
    } catch (PDOException $e) {
      exit('DbConnectError:'.$e->getMessage());
    }
  }




?>
