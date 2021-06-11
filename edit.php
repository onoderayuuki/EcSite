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

//-- unsplash ----------------------
require './vendor/autoload.php';
Unsplash\HttpClient::init([
  'applicationId'  => 'WtXaQuUo6QB9xPxsoqwCBLIWm0S1ImqGtDzbluWxlNI',
  'secret'  => 'WRqMevmuTh_xPpy31SUsI-_-FCtFrkz_2WrHTd5kyVA',
  'callbackUrl'  => 'https://your-application.com/oauth/callback',
  'utmSource' => ''
]);

// Load
$photos = array();

for ($i = 0; $i < 5; $i++) {
  $photo = Unsplash\Photo::random();
  $photo_array = array(
    'id' => $photo->id, 'thumb' => $photo->urls['thumb'], 'regular' => $photo->urls['regular']
  );
  $photos[] = $photo_array;
}

// echo '<pre>';
// var_dump($photos);
// echo '</pre>';
// // //------------
// $photos = [
//   array(
//     "id" => "rhPgcJ9deik", "thumb" => "https://images.unsplash.com/photo-1622057180019-4ee282cd6b40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjY&ixlib=rb-1.2.1&q=80&w=200", "regular" => "https://images.unsplash.com/photo-1622057180019-4ee282cd6b40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjY&ixlib=rb-1.2.1&q=80&w=400"
//   ),
//   array(
//     "id" => "H7dpehwf-sU", "thumb" =>
//     "https://images.unsplash.com/photo-1622890276113-96e6f69e762b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjY&ixlib=rb-1.2.1&q=80&w=200", "regular" =>
//     "https://images.unsplash.com/photo-1622890276113-96e6f69e762b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjY&ixlib=rb-1.2.1&q=80&w=400"
//   ),
//   array(
//     "id" => "lqJtPwFbBo0", "thumb" =>
//     "https://images.unsplash.com/photo-1623133249410-e056d386a190?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjY&ixlib=rb-1.2.1&q=80&w=200", "regular" =>
//     "https://images.unsplash.com/photo-1623133249410-e056d386a190?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjY&ixlib=rb-1.2.1&q=80&w=400"
//   ),
//   array(
//     "id" => "dt16NTAG97I", "thumb" =>
//     "https://images.unsplash.com/photo-1621527115366-7b5796561685?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjc&ixlib=rb-1.2.1&q=80&w=200", "regular" =>
//     "https://images.unsplash.com/photo-1621527115366-7b5796561685?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjc&ixlib=rb-1.2.1&q=80&w=400"
//   ),
//   array(
//     "id" => "cGdwMz4_XbM", "thumb" =>
//     "https://images.unsplash.com/photo-1621254770538-802be8e86704?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjc&ixlib=rb-1.2.1&q=80&w=200", "regular" =>
//     "https://images.unsplash.com/photo-1621254770538-802be8e86704?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMzYzODN8MHwxfHJhbmRvbXx8fHx8fHx8fDE2MjMzNzkzMjc&ixlib=rb-1.2.1&q=80&w=400"
//   )
// ];
// echo '<pre>';
// var_dump($photos);
// echo '</pre>';
//-------------
$photos_json = json_encode($photos);
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
  <main>
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
      <button id="save">Save</button>
    </div>
  </main>
  <aside class="images_box">
    <a href="#" class="imgbox" id='0'>><img src="<?= $photos[0]['thumb'] ?>"></a>
    <a href="#" class="imgbox" id='1'><img src="<?= $photos[1]['thumb'] ?>"></a>
    <a href="#" class="imgbox" id=2><img src="<?= $photos[2]['thumb'] ?>"></a>
    <a href="#" class="imgbox" id=3><img src="<?= $photos[3]['thumb'] ?>"></a>
    <a href="#" class="imgbox" id=4><img src="<?= $photos[4]['thumb'] ?>"></a>
  </aside>
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
    const addMultipleEventListener = (target, eventNames, listener) => {
      const events = eventNames.split(" ");
      events.forEach(event => target.addEventListener(event, listener, false));
    };
    const PHOTOS = <?= $photos_json ?>;
    console.log(PHOTOS);

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
    const STAGE = new Konva.Stage({
      container: "container",
      width: 707,
      height: 500,
    });
    const LAYER = new Konva.Layer();

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

    // const sources = {
    // back: "$row["imageSrc"] ?"
    // };

    function loadImages(sources, callback) {
      let images = {};
      let loadedImages = 0;
      let numImages = 0;
      for (var src in sources) {
        numImages++;
      }
      for (var src in sources) {
        images[src] = new Image();
        images[src].crossOrigin = 'Anonymous';
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
      LAYER.add(BACK_IMAGE);
      LAYER.add(TEXT_IMAGE);
    }

    //html2canvas  **************************************************
    function renderText() {
      // convert DOM into image
      html2canvas(document.querySelector(".ql-editor"), {
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
    //save
    document.getElementById('download').addEventListener(
      'click',
      function() {
        // const dataURL = stage.toDataURL();
        downloadURI(STAGE.toDataURL(), 'image.png');
      },
      false
    );

    document.getElementById("save").addEventListener(
      'click',
      function() {
        document.querySelector("#textX").value =
          TEXT_IMAGE.getAttrs()["x"];
        document.querySelector("#textY").value =
          TEXT_IMAGE.getAttrs()["y"];
        document.querySelector("#imageSrc").value =
          BACK_IMAGE.getAttrs()["image"].src;
        document.querySelector("#textJSON").value = JSON.stringify(quill.getContents());
        document.querySelector("#imageBase64").value = STAGE.toDataURL();
        document.saveForm.submit();
      },
      false
    );

  const trigger = document.querySelectorAll(".imgbox");
  trigger.forEach(function(target) {
    target.addEventListener('click', function() {
      console.log(this);
      loadImages( {back: PHOTOS[this.id]['regular'] }, buildStage)
    },false);
  });

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
    STAGE.add(LAYER);
    loadImages({
      back: "<?= $row["imageSrc"] ?>"
    }, buildStage);
    renderText();
  </script>
</body>

</html>