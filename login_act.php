<?php
session_start();
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];
$sid = session_id();

try {
  $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

$sql = "SELECT * FROM editor WHERE editor_id=:lid AND editor_password=:lpw AND editor_isLive =1";
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

if( $val["editor_id"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["name"]       = $val['name'];
  header("Location: edit_list.php");
}else{
  header("Location: login.php");
  
}
//処理終了
exit();
?>

