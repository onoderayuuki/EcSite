<?php
session_start();
include("funcs.php");
loginCheck();


try {
  $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT cardID,editorID,imageBase64 FROM cards WHERE cardID > 0");
$status = $stmt->execute();

$view="";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    if ($result["editorID"]=$_SESSION["editorID"]) {
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
      <a href="edit_list.php">⚪︎myEdits</a>
      <a href="logout.php">Logout</a>
      
    </header>
    <div class="outer">
      <main class="wrapper-main">
        <!--並び替えボタン-->
        <div class="sort-area">
          <ul class="sort-list flex-parent">
            <li class="sort-item"><a href="#"> ▼ addDate</a></li>
            <li class="sort-item"><a href="#"> △ addDate</a></li>
            <!-- <li class="sort-item"><a href="#">▼ favoritDate</a></li> -->
          </ul>
        </div>
        <!--end 並び替えボタン-->
        <!--商品リスト-->
        <div class="cards_list">
        <a id="plus-area" href="edit.php?id=0">＋</a>

        <?php echo $view; ?>
          <!-- <a href="#"><img src="./images/sample1.jpg"  /></a>
          <a href="#"><img src="./images/sample2.jpg"  /></a>
          <a href="#"><img src="./images/sample3.jpg" /></a>
          <a href="#"><img src="./images/sample4.jpg"  /></a>
          <a href="#"><img src="./images/sample5.jpg" /></a>
          <a href="#"><img src="./images/sample5.jpg"  /></a>
          <a href="#"><img src="./images/sample4.jpg"  /></a>
          <a href="#"><img src="./images/sample3.jpg" /></a>
          <a href="#"><img src="./images/sample2.jpg"  /></a>
          <a href="#"><img src="./images/sample1.jpg" /></a>
          <a href="#"><img src="./images/sample1.jpg"  /></a>
          <a href="#"><img src="./images/sample2.jpg"  /></a>
          <a href="#"><img src="./images/sample3.jpg" /></a>
          <a href="#"><img src="./images/sample4.jpg"  /></a>
          <a href="#"><img src="./images/sample5.jpg" /></a> -->
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