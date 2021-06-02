<?php


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

$textX  = $_POST["text_x"];
$textY  = $_POST["text_y"];
$imageSrc = $_POST["image_src"];
$textJSON = $_POST["text_json"];

var_dump($_POST) ;

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
$sql = "INSERT INTO cards(cardID, textX, textY, textJSON, imageSrc, editorID, addDate)
VALUES(NULL, :textX, :textY, :textJSON, :imageSrc, '1' , sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':textX', $textX, PDO::PARAM_INT);
$stmt->bindValue(':textY', $textY, PDO::PARAM_INT); 
$stmt->bindValue(':textJSON', $textJSON);
$stmt->bindValue(':imageSrc', $imageSrc);
$status = $stmt->execute();

// //----------------------------------------------------
// //５．データ登録処理後
// //----------------------------------------------------
if($status==false){
  $error = $stmt->errorInfo();
  echo '<br>';
 var_dump($error);
//   exit("QueryError:".$error[2]);
}else{
    echo 'ok';
//   header("Location: item.php");
//   exit;
}
 ?>
