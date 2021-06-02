<?php

//GETでidを取得
// if(!isset($_GET["id"]) || $_GET["id"]==""){
//   exit("ParamError!");
// }else{
//   $id = intval($_GET["id"]); //intval数値変換
// }
$id = 1;
try {
  $pdo = new PDO('mysql:dbname=Editing;host=localhost;charset=utf8', 'root', 'root');
} catch (PDOException $e) {
  exit('DbConnectError:' . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM cards WHERE cardID=:id");
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
  <link rel="stylesheet" href="./css/edit.css">
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <meta charset="utf-8" />
  <title>yourEdit</title>

</head>

<body>
<header class="header">
      <h1 class="site-title"><a href="#">Moonlight 🌒</a></h1>
      <a href="cart.php" class="btn btn-cart">⚫︎favorit</a>
      <!--form-->
      <form action="" method="get" class="search-form">
        <div>
          <input type="text" placeholder="Serch" class="search-box" />
          <input type="submit" value="送信" class="search-submit" />
        </div>
      </form>
      <!--end form-->
      <a href="cart.php" class="btn btn-cart">+Edit</a>
      <a href="cart.php" class="btn btn-cart">…myedits</a>
    </header>
  <div id="editor-container">
    <span>
      くれなゐの二尺伸びたる薔薇の芽の針やはらかに春雨のふる
    </span>
  </div>
  <div id="container"></div>
  <button id="button">Save</button>
  <form action="edit.php" method="POST" name="saveForm">
    <p>
      imageX<input id="text_x" name="text_x" value="" />
      imageY<input id="text_y" name="text_y" value="" />
    </p>
    <p>
      text_json<input type="json" id="image_src" name="image_src" value="" />
    </p>
    <textarea id="text_json" name="text_json" value=""></textarea>
    <!-- <input type="submit" class="" value="表示" /> -->
  </form>

  <script>
    // quill:editor ********************************************************
    const quill = new Quill("#editor-container", {
      modules: {
        toolbar: [
          [{
            header: [1, 2, false]
          }],
          [{
            font: []
          }],
          ["bold", "italic", "underline"],
          //文字色
          [{
            color: []
          }, {
            background: []
          }],
          ["image", "code-block"],
        ],
      },
      placeholder: "Compose an epic...",
      theme: "snow", // or 'bubble'
    });

    //Konva:canvas  *******************************************************

    // konva init
    const stage = new Konva.Stage({
      container: "container",
      width: 707,
      height: 500,
    });
    const layer = new Konva.Layer();
    stage.add(layer);

    //konva:text
    const TEXT_IMAGE = new Konva.Image({
      x: <?= $row["textX"] ?>,
      y: <?= $row["textY"] ?>,
      draggable: true,
      // stroke: "red",
      scaleX: 1 / window.devicePixelRatio,
      scaleY: 1 / window.devicePixelRatio,
    });

    //Back_Image
    const BACK_IMAGE = new Konva.Image({
      x: 0,
      y: 0,
    });

    const sources = {
      // back: "./images/sample.jpg", //***
      back: "<?= $row["imageSrc"] ?>"
    };

    function loadImages(sources, callback) {
      let images = {};
      let loadedImages = 0;
      let numImages = 0;
      for (var src in sources) {
        numImages++;
      }
      for (var src in sources) {
        images[src] = new Image();
        images[src].onload = function() {
          if (++loadedImages >= numImages) {
            callback(images);
          }
        };
        images[src].src = sources[src];
      }
    }

    function buildStage(images) {
      BACK_IMAGE.setAttr("image", images.back);
      layer.add(BACK_IMAGE);
      layer.add(TEXT_IMAGE);
    }

    //html2canvas  **************************************************
    function renderText() {
      // convert DOM into image
      html2canvas(document.querySelector(".ql-editor"), {
        //***
        backgroundColor: "rgba(0,0,0,0.2)",
      }).then((canvas) => {
        // show it inside Konva.Image
        TEXT_IMAGE.image(canvas);
      });
    }

    // batch updates, so we don't render text too frequently
    let timeout = null;

    function requestTextUpdate() {
      if (timeout) {
        return;
      }
      timeout = setTimeout(function() {
        timeout = null;
        renderText();
      }, 100);
    }

    //Event **************************************************************
    quill.on("text-change", requestTextUpdate);
    
    document.getElementById("button").onclick = function() {
      (async () => {
        const updateForm = new Promise(function(resolve) {
          // setTimeout(() => {
          document.querySelector("#text_x").value =
            TEXT_IMAGE.getAttrs()["x"];
          document.querySelector("#text_y").value =
            TEXT_IMAGE.getAttrs()["y"];
          document.querySelector("#image_src").value =
            BACK_IMAGE.getAttrs()["image"].src;
          document.querySelector("#text_json").value = JSON.stringify(quill.getContents());
          // document.querySelector("#text_json").value = quill.root.innerHTML;
          console.log('5000');
          resolve();
          // }, 5000);
        });
        await updateForm;
        document.saveForm.submit();
      })();
    };

    //Init *******************************************************************
    quill.setContents(<?= $row["textJSON"] ?>);
    loadImages(sources, buildStage);
    renderText();

</script>
</body>

</html>