<?php
session_start();
include("funcs.php");
loginCheck();

$editorID = intval($_SESSION["editorID"]);

//GET判定_type
if (!isset($_GET["type"]) || $_GET["type"] == "") {
  $type="all";
} else {
  $type = $_GET["type"];
}

if (!isset($_GET["order"]) || $_GET["order"] == "") {
  $order="desc";
} else {
  $order = $_GET["order"];
}


//接続準備
try {
  $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//SQL用意
if($type==="myedits"){
  $sql = "SELECT cardID,IFNULL(editorID,0) as editorID,imageBase64 FROM cards WHERE cardID > 0 and IFNULL(editorID,0)=:editorID ORDER BY addDate ";
  $sql  .= $order;
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':editorID', $editorID, PDO::PARAM_INT);
  $status = $stmt->execute();
  // }elseif($type==="favorit"){  
}else{
  $sql = "SELECT cardID,IFNULL(editorID,0) as editorID,imageBase64 FROM cards WHERE cardID > 0 ORDER BY addDate ";
  $sql  .= $order;
  // $stmt = $pdo->prepare("SELECT cardID,IFNULL(editorID,0) as editorID,imageBase64 FROM cards WHERE cardID > 0 ");
  $stmt = $pdo->prepare($sql);
  $status = $stmt->execute();
}

$view="";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    if ($result["editorID"]===$editorID) {
      $view .= '<a href="edit.php?id='.$result["cardID"].'"><img src="'.$result["imageBase64"].'" width="200" /></a>';
    } else {
      $view .= '<a href="card.php?id='.$result["cardID"].'"><img src="'.$result["imageBase64"].'" width="200" /></a>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <title>Moonlight</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header class="header">
      <h1 class="site-title"><a href="edit_list.php">Moonlight 🌒</a></h1>
      <a href="edit_list.php">⚫︎favorit</a>
      <!--form-->
      <form action="" method="get" class="search-form">
        <div>
          <input type="text" placeholder="Serch" class="search-box" />
          <input type="submit" value="送信" class="search-submit" />
        </div>
      </form>
      <!--end form-->
      <a href="./edit_list.php?type=myedits&order=desc">⚪︎myEdits</a>
      <a href="logout.php">Logout</a>
      
    </header>
    <div class="outer">
      <main class="wrapper-main">
        <!--並び替えボタン-->
        <div class="sort-area">
          <ul class="sort-list flex-parent">
            <li class="sort-item"><a href="./edit_list.php?type=<?=$type?>&order=desc"> ▼ addDate</a></li>
            <li class="sort-item"><a href="./edit_list.php?type=<?=$type?>&order=asc"> △ addDate</a></li>
            <!-- <li class="sort-item"><a href="#">▼ favoritDate</a></li> -->
          </ul>
        </div>
        <!--end 並び替えボタン-->
        <!--商品リスト-->
        <div class="cards_list">
        <a id="plus-area" href="edit.php?id=0">＋</a>

        <?php echo $view; ?>
        </div>
        <!-- end 商品リスト-->
        <!-- ページャー -->
        <div>
        <ul class="pager clearfix">
          <li class="pager-item"><a href="#">1</a></li>
          <li class="pager-item"><a href="#">2</a></li>
        </ul>
      </div>
        <!-- end ページャー-->
      </main>
    </div>

    <script src="http://code.jquery.com/jquery-3.0.0.js"></script>
    <script src="js/jquery.bxslider.min.js"></script>
    <script></script>
  </body>
</html>