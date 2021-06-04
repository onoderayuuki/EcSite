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
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/edit.css">
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <meta charset="utf-8" />
  <title>yourEdit</title>

</head>

<body>
  <header class="header">
    <h1 class="site-title"><a href="edit_list.php">Moonlight 🌒</a></h1>
    <a href="edit_list.php">⚫︎favorit</a>
    <a href="edit_list.php">…myedits</a>
    <a href="logout.php">Logout</a>
  </header>
  <!-- 書き込みフォーム -->
  <div id="editor-wrapper" class="editor-wrapper">
  <div id="editor-container" class="editor-container">
    <span>
      くれなゐの二尺伸びたる薔薇の芽の針やはらかに春雨のふる
    </span>
  </div>
  </div>
  <!-- メインキャンバス -->
  <div id="container" class="container"></div>
  <!-- 保存と送信 -->
  <div class="button-wrapper">
    <button id="download">download</button>
    <button id="button">Save</button>
  </div>
  <!-- 送信フォーム -->
  <form action="edit_add.php" method="POST" name="saveForm">
    <p>id<input id="cardID" name="cardID" value="<?= $id ?>" /></p>
    <p>
      imageX<input id="textX" name="textX" value="" />
      imageY<input id="textY" name="textY" value="" />
    </p>
    <p>
      imageSrc<input type="json" id="imageSrc" name="imageSrc" value="" />
    </p>
    <textarea id="textJSON" name="textJSON" value=""></textarea>
    <textarea id="imageBase64" name="imageBase64" value=""></textarea>
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

    function downloadURI(uri, name) {
      var link = document.createElement('a');
      link.download = name;
      link.href = uri;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      delete link;
    }

    //Event **************************************************************
    quill.on("text-change", requestTextUpdate);

    document.getElementById('download').addEventListener(
      'click',
      function() {
        const dataURL = stage.toDataURL();
        downloadURI(dataURL, 'image.png');
      },
      false
    );

    document.getElementById("button").onclick = function() {
      // (async () => {
        // const updateForm = new Promise(function(resolve) {
          document.querySelector("#textX").value =
            TEXT_IMAGE.getAttrs()["x"];
          document.querySelector("#textY").value =
            TEXT_IMAGE.getAttrs()["y"];
          document.querySelector("#imageSrc").value =
            BACK_IMAGE.getAttrs()["image"].src;
          document.querySelector("#textJSON").value = JSON.stringify(quill.getContents());
          document.querySelector("#imageBase64").value = stage.toDataURL();
          // resolve();
        // });
        // await updateForm;
        document.saveForm.submit();
      // })();
    };

    //リサイズ
    document.addEventListener('DOMContentLoaded', () => {
      const resizeable = document.getElementById('editor-wrapper');
      const observer = new MutationObserver(() => {
        requestTextUpdate();
      });
      observer.observe(resizeable, {
        attriblutes: true,
        attributeFilter: ["style"]
      });
    }, false);

    //Init *******************************************************************
    quill.setContents(<?= $row["textJSON"] ?>);
    loadImages(sources, buildStage);
    renderText();
  </script>
</body>

</html>