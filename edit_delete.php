<?php

session_start();
include("funcs.php");
loginCheck();


if (!isset($_GET["cardID"]) || $_GET["cardID"] == "") {
  exit("ParamError!");
} else {
  $cardID = intval($_GET["cardID"]);
}

echo '<pre>';
var_dump($cardID);
echo '</pre>';

$pdo = createPDO();
$sql = "UPDATE cards SET isLive=0 WHERE cardID =:cardID";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':cardID', $cardID, PDO::PARAM_INT);
$status = $stmt->execute();

// //----------------------------------------------------
// //５．データ登録処理後
// //----------------------------------------------------
if($status==false){
  $error = $stmt->errorInfo();
  echo '<pre>';
  var_dump($error);
  echo '</pre>';
  echo '<pre>';
  var_dump($sql);
  echo '</pre>';
//   exit("QueryError:".$error[2]);
}else{
    // echo 'ok';
  header("Location: edit_list.php");
//   exit;
}
 ?>

