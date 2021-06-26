<?php
session_start();
include("funcs.php");

$lid = $_POST["lid"];
$lpw = $_POST["lpw"];
$sid = session_id();

// var_dump($_POST);

// try {
//   $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
// } catch (PDOException $e) {
//   exit('DbConnectError:'.$e->getMessage());
// }
$pdo = createPDO();

// var_dump($pdo);

$sql = "SELECT * FROM editor WHERE editorID=:lid AND editorPassword=:lpw AND editorIsLive =1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$res = $stmt->execute();

//SQL実行時にエラーがある場合
if($res==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

$val = $stmt->fetch(); //1レコードだけ取得する方法

if( $val["editorID"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["editorID"]  = $val["editorID"];
  $_SESSION["editorName"] = $val['editorName'];
  header("Location: edit_list.php");
}else{

  header("Location: login.php");
  
}
//処理終了
// exit();
?>

