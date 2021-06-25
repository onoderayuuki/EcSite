<?php

session_start();
include("funcs.php");
loginCheck();

//----------------------------------------------------
//１．入力チェック(受信確認処理追加)
//----------------------------------------------------
// if(!isset($_POST["text_x"]) || $_POST["text_x"] == ""){
//   exit("x_error");
// }
// check("text_x");
//----------------------------------------------------
//２. POSTデータ取得
//----------------------------------------------------
$cardID  = $_POST["cardID"];
if ($cardID == 0) {
  $cardID = 'NULL';
}

$textX  = $_POST["textX"];
$textY  = $_POST["textY"];
$imageSrc = $_POST["imageSrc"];
$textJSON = $_POST["textJSON"];
$imageBase64 = $_POST["imageBase64"];
$editorID = intval($_SESSION["editorID"]);
var_dump($editorID);
// //----------------------------------------------------
// //３. DB接続します(エラー処理追加)
// //----------------------------------------------------
try {
  $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8','root', 'root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

// //----------------------------------------------------
// //４．データ登録SQL作成
// //----------------------------------------------------
$sql = "INSERT INTO cards(cardID, textX, textY, textJSON, imageSrc,imageBase64 ,editorID, addDate)
                            VALUES($cardID
                            , :textX
                            , :textY
                            , :textJSON
                            , :imageSrc
                            , :imageBase64
                            , :editorID
                            , sysdate()
                            )
ON DUPLICATE KEY UPDATE textX=VALUES(textX)
                                            ,textY=VALUES(textY)
                                            ,textJSON=VALUES(textJSON)
                                            ,imageSrc=VALUES(imageSrc)
                                            ,imageBase64=VALUES(imageBase64)
                            ";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':textX', $textX, PDO::PARAM_INT);
$stmt->bindValue(':textY', $textY, PDO::PARAM_INT); 
$stmt->bindValue(':textJSON', $textJSON);
$stmt->bindValue(':imageSrc', $imageSrc);
$stmt->bindValue(':imageBase64', $imageBase64);
$stmt->bindValue(':editorID', $editorID, PDO::PARAM_INT);
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
