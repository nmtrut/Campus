<?php
require_once('./functions.php');
session_start();

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 送られた値を取得
    $name = $_POST['name'];
    $picture = $_POST['picture'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $student = $_POST['student'];
    $gakuseki = $_POST['gakuseki'];

    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($name)||empty($password)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: login.php");
        return;
    }

    /**
     * 認証
     */
    $db = connectDb();
    // 送られたusernameを使ってDBを検索する
    $sql = 'SELECT * FROM members WHERE name = :name';
    $statement = $db->prepare($sql);
    $statement->execute(['name' => $name]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // ユーザーが取得できなかったら、それは入力されたusernameが間違っているということ
    if (!$user) {
        $_SESSION["error"] = "入力した情報に誤りがあります。";
        header("Location: login.php");
        return;
    }

    // パスワードとパスワード確認が一致しているか
    if (crypt($password, $user['password']) !== $user['password']) {
        $_SESSION["error"] = "入力した情報に誤りがあります。";
        header("Location: login.php");
        return;
    }

    // ログイン処理
    // ユーザー情報をセッションに格納する
    $_SESSION["user"]["id"] = $user['id'];
    $_SESSION["user"]["name"] = $user['name'];

    $_SESSION["success"] = "ログインしました。";
    header("Location: index.php");
}

?>

<html lang="ja">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">

  <!-- Latest compiled and minified CSS -->
   		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>
<body>
<body background="wood-texture.jpg">
<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="./user-register.php">新規登録</a></li>
                <li role="presentation"><a href="./login.php">ログイン</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Campus Room</h3>
    </div>

    <!-- Success Message -->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="success">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Success:</span>
            <?php echo $_SESSION['success']; ?>
            <?php $_SESSION['success'] = null; ?>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?php echo $_SESSION['error']; ?>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>


  <!-- "twitter"
  <h2>Twitterでログイン</h2>
  <a href="./twitter-login.php" class="btn btn-success">Twitterログインはこちら</a>
  -->


    <h2>ログイン</h2>

    <form action="" method="post">
        <div class="form-group">
            <label for="name-input">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name-input" placeholder="">
        </div>
        <div class="form-group">
            <label for="password-input">パスワード</label>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="">
        </div>
        <input type="submit" class="btn btn-primary" value="ログイン">
    </form>

</div> <!-- /container -->
</body>
</body>
</html>
