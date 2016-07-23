<?php
require_once('./functions.php');
session_start();

// ログインしていなかったらログイン画面に遷移
redirectIfNotLogin();  // ※ この関数はfunctions.phpに定義してある

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $file=$_FILES['pictures']['tmp_name'];
    $fileName=$_FILES['pictures']['name'];

    // 未入力の値が無いか
    if (empty($fileName))  {
        $_SESSION["error"] = "写真が選択されていません";
        header("Location: new-articles.php");
        return;
    }


    $ext = substr($fileName, -3);
    if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'bmp' && $ext != 'peg' &&
        $ext != 'JPG' && $ext != 'GIF' && $ext != 'PNG' && $ext != 'BMP' && $ext != 'PEG')  {
        $_SESSION["error"] = "画像の拡張子を確認してください";
        header("Location: new-articles.php");
        return;
    }


    // var_dump($fileName);
    $image = date('YmdHis').$_FILES['pictures']['name'];
    if($_FILES['pictures']['error']==UPLOAD_ERR_OK&&
      is_uploaded_file($file)){
        move_uploaded_file($file,'images/'.$image);
    }

    // $_SESSION['join']=$_POST;
    // $_SESSION['join']['pictures'] = $image;
    // var_dump($_SESSION['user']['id']);
    // var_dump($fileName);

    // 記事を登録
    $db = connectDb();
    $sql = "INSERT INTO articles(user_id, pictures,theme) VALUES(:user_id, :pictures,:theme)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':pictures' => $image,
        ':theme' => date(n)
    ]);
    if (!$result) {
        die('Database Error');
    }

    $_SESSION["success"] = "記事を投稿しました";
    // 一覧画面に遷移
    header("Location: index.php");
}



?>

<html lang="ja">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>Campus Room</title>

  	<!-- Latest compiled and minified CSS -->
   		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>



<body>
<div class="container">

    <div class="header clearfix">
      <nav>
          <ul class="nav nav-tabs">
              <li><a href="./index.php">ホーム</a></li>
              <li><a href="./articles.php">一覧</a></li>
              <li class="active"><a href="./new-articles.php">投稿</a></li>
              <li><a href="./search.php">検索</a></li>
              <li><a href="./ranking.php">ランキング</a></li>
              <li><a href="./mypage.php">マイページ</a></li>
              <li><a href="./logout.php">ログアウト</a></li>
           </ul>
      </nav>
        <h3 class="text-muted">Campus Room</h3>
    </div>

    <!-- Error Message -->
    <!-- もしセッションにエラーメッセージが入っていたら表示する -->
    <!-- 一回表示したら、セッションから削除する -->
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $_SESSION['error']; ?>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>

<div class="panel panel-primary">
  <form action="./new-articles.php" method="POST" enctype="multipart/form-data">
  <div class="panel-heading">画像選択</div>
    <!-- <label for="pictures" class="control-label"> -->

    <!-- </label> -->

  <div class="panel-body">
    <input type="file" name="pictures">
  <input type="submit" value="ファイルをアップロードする">
    </div>
	</form>
  </div>


</div>

</body>
</html>
