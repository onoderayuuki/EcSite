<?php

session_start();
include("funcs.php");
loginCheck();

if (!isset($_GET["id"]) || $_GET["id"] == "") {
  exit("ParamError!");
} else {
  $id = intval($_GET["id"]);
}

try {
  $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
  exit('DbConnectError:' . $e->getMessage());
}

$sql = "SELECT cardID
                      , textX
                      , textY
                      , textJSON
                      , imageSrc
                      , imageBase64
                      , addDate
                      ,editorName
            FROM cards LEFT JOIN editor ON cards.editorID=editor.editorID 
            WHERE cardID=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:" . $error[2]);
} else {
  $row = $stmt->fetch(); //１レコードだけ取得：$row["フィールド名"]で取得可能
}

// var_dump($row);
?>

<!DOCTYPE html>
<html>

<head>
  <script src="https://unpkg.com/konva@8.0.2/konva.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css" />
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/edit.css">
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <meta charset="utf-8" />
  <title>yourEdit</title>

</head>

<body>
  <header class="header">
    <h1 class="site-title"><a href="edit_list.php">Moonlight 🌒</a></h1>
    <!-- <a href="edit_list.php">⚫︎favorit</a>
    <a href="edit_list.php">…myedits</a> -->
    <!-- <a href="logout.php">Logout</a> -->
  </header>
<main>
  <div class="image-wrapper">
    <img src="<?= $row["imageBase64"] ?>" />
  </div>

  <div class="caption">
    <p><?= $row["addDate"] ?></p>
    <p><?= $row["editorName"] ?></p>
  </div>
  </main>
</body>

</html>