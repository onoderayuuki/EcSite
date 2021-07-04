<?php

session_start();
include("funcs.php");
loginCheck();

// GET ----------------------------------------------------

if (!isset($_GET["cardID"]) || $_GET["cardID"] == "") {
  exit("ParamError!");
} else {
  $cardID = intval($_GET["cardID"]);
}

$editorID = intval($_SESSION["editorID"]);

// INSERT UPDATE ----------------------------------------------------
$pdo = createPDO();
$sql = "INSERT INTO favorits(editorID, cardID, favorit, favoritDate) 
            VALUES (:editorID,:cardID,1,sysdate())";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':editorID', $editorID, PDO::PARAM_INT);
$stmt->bindValue(':cardID', $cardID, PDO::PARAM_INT);
$status = $stmt->execute();

// header ----------------------------------------------------
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

