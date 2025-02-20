# PHP1

https://discegaudere.sakura.ne.jp/Moonlight

![image](https://user-images.githubusercontent.com/38471145/121733006-e328c980-cb2d-11eb-98b8-b18ae6aa769f.png)
![image](https://user-images.githubusercontent.com/38471145/121733058-f5a30300-cb2d-11eb-875a-44af424c3e6a.png)
![image](https://user-images.githubusercontent.com/38471145/121733143-13706800-cb2e-11eb-928c-2f9084a5fe39.png)
![image](https://user-images.githubusercontent.com/38471145/121733352-53374f80-cb2e-11eb-9cb7-12896b8b3dba.png)

## 概要・操作方法
 - プロの写真（unsplash API）を使って簡単にコピーライト風画像を作成共有できるサイト
 - ログイン→ 一覧 →自分の画像ならEdit画面、他ユーザーの画像なら閲覧画面
## 工夫した点
 - 一覧画面
     - DBにBaase64での画像情報を入れてリンクサムネイルとして表示するようにした 
     - セッションのログインユーザーIDと画像作成ユーザーのIDを比較してEditと閲覧のリンクを判定生成
 - Edit画面
     - 色や枠の大きさを変えたリッチテキストをその場で画像に反映できるようにした（Konva.jsのデモを参照）
     -  unsplashのAPIからランダム画像を取得して自由に差し替えできるようにした
## 残課題
 - Favarit機能：サイト名のMoonにちなんで月が満ちるようなFavorit表示にしたい。レーティングはVueでの実装が多かったので後回しにした。
 - 一覧画面の「検索抽出」「Favorit抽出」「myEdit抽出」「日付昇順降順」：同じPHPのままSQL条件を分岐書き換えで対応したいと思っている
     - [質問] 同じPHPページでSQLだけ書き換える時は ①GETで条件FLGを渡して、②FLGにしたがってifで別のSQLを設定する という形で良いのでしょうか。よくあるやり方などあるでしょうか？（SQL分岐はあまりさせないとかGET出ない方法で呼び出すとか）
 - Edit画面の文字枠の背景色変更、フォント追加、縦書き対応
 - Edit画面の画像サイズや切り取り位置の変更
 - 写真と同じように引用できる文学作品のAPIとかあればよかったのだが意外となかった。  
## 感想
 - フレームワークを使って作り直すプロトタイプのつもりで作った。デザインや必要な機能の入り口とEditのコアになる部分など必要十分な所だけ作り込めたのでよかった。
 　　　- リッチテキストを画像にして扱うのはKonva.jsのデモから丸々パクった否参考にさせてもらっている。https://konvajs.org/docs/sandbox/Rich_Text.html
 - 創作で「文庫ページメーカー」というサービスがあり、画像と文章を組み合わせられる。ただボタンを押して生成するまで完成形がわからない。その『編集』の楽しみを手軽に味わえないかと思ってところから発想した。縦書き対応できていないので広告写真や表紙風画像しか作れない。
 - MoonLightというタイトルは、写真も文章も自分のオリジナルではないけれどその組み合わせに微かなオリジナリティやクリエイティブを見出すという所から、太陽光を反射する月をイメージした。
 - 実装しなかったけれどいいね数を月の満ちで表したいと思った。規定数までFavが着いたらあとはどんなに数が増えても表示上は満月のまま変わらないという仕様の予定。Favとのより良い付き合い方を考えたい。  
## Links
- Quill：リッチテキストエディタのプラグイン：https://quilljs.com/
- Konva.js：Canvas編集ライブラリ：https://konvajs.org/ 
- html2canvas ：htmlをcanvasに反映できる：https://html2canvas.hertzen.com/
- Unsplash API：無料の写真API：https://unsplash.com/

# PHP2
## 0626,27変更点
 - 表示の際にログインユーザーにかかわらず全てのカードを修正できていた障害を修正。
 - 一覧画面上のaddDateの昇順降順をGETのorder値からSQLに追記させることで最小限の記述で並べ替えを実装
 - myEditsページに関しても上記と同様の手法でページ追加せず実装
 - デプロイに備えてDB環境変数を.envに外部ファイル化
 - dotenvを追加してPDO作成を共通関数に   
 - DBのエクスポート （SQL／moonlight .sq）
 - さくらレンタルサーバーにて公開（index.htmlの設定） https://discegaudere.sakura.ne.jp/Moonlight

# PHP3
## 0703,4変更点
![image](https://user-images.githubusercontent.com/38471145/125170726-466c5100-e1eb-11eb-827c-7bbab27a021b.png)

### favorit関連機能の追加
- myfavoritからfavoritしたもののみの一覧が表示されるように
    - favoritテーブルを別にして登録リストとしてかつ集計ソースとして使えるようにしたこと（正規化）が個人的ポイント
- favorit数に連動して月が満ちるような表示
    - いいねの数と上手に付き合う方法を考えた
