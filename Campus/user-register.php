<?php

// functions.phpを読み込む. よく使う処理をまとめた関数を定義している
require_once('./functions.php');
// セッションを利用する
session_start();

/*
 * 普通にアクセスした場合: GETリクエスト
 * 登録フォームからSubmitした場合: POSTリクエスト
 */
// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // if (isset($_POST["submit"])) { //もしPOSTに [submit] があれば
    if ($_POST["student"] == "univ") {
      $student = "大学生";
    }
    elseif ($_POST["student"] == "high") {
      $student = "高校生";
    }
    else {
      $student = "その他";
    }
  // }

  // if ($_POST["daigaku"] == "") {
  //   $daigaku = "";
  // }
  // elseif ($_POST["daigaku"] == "waseda") {
  //   $daigaku = "早稲田大学";
  // }
  // elseif ($_POST["daigaku"] == "keio") {
  //   $daigaku = "慶応義塾大学";
  // }
  // elseif ($_POST["daigaku"] == "meiji") {
  //   $daigaku = "明治大学";
  // }
  // elseif ($_POST["daigaku"] == "aogaku") {
  //   $daigaku = "青山学院大学";
  // }
  // elseif ($_POST["daigaku"] == "rikkyo") {
  //   $daigaku = "立教大学";
  // }
  // elseif ($_POST["daigaku"] == "chuo") {
  //   $daigaku = "中央大学";
  // }
  // elseif ($_POST["daigaku"] == "hosei") {
  //   $daigaku = "法政大学";
  // }
  // else {
  //   $student = "学習院大学";
  // }

    // 送られた値を変数に格納
    $name = $_POST['name'];
    $picture = $_POST['picture'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password-confirmation'];
    // $student = $_POST['student'];
    $daigaku = $_POST['daigaku'];
    $gakuseki = $_POST['gakuseki'];



    /**
     * 入力値チェック
     */
    // 未入力の項目があるか
    if (empty($name) || empty($mail) || empty($password) ||  empty($password_confirmation) || empty($student)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: user-register.php");
        return;
    }

    // パスワードとパスワード確認が一致しているか
    if ($password !== $password_confirmation) {
        $_SESSION["error"] = "パスワードが一致しません";
        header("Location: user-register.php");
        return;
    }


    /**
     * 登録処理
     */
    // DB接続
    $db = connectDb();  // ※ この関数はfunctions.phpに定義してある
    // DBにインサート
    $sql = "INSERT INTO members(name,picture,mail,password,student,daigaku,gakuseki) VALUES(:name,:picture,:mail,:password,:student,:daigaku,:gakuseki)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':name' => $name,
        ':picture' => $picture,
        ':mail' => $mail,
        ':password' => crypt($password),
        ':student' => $student,
        ':daigaku' => $daigaku,
        ':gakuseki' => $gakuseki,

    ]);

    var_dump($student);
    var_dump($daigaku);

    if (!$result) {
        die('Database Error');
    }

    // セッションにメッセージを格納
    $_SESSION["success"] = "登録が完了しました。ログインしてください。";
    // ログイン画面に遷移
    header("Location: login.php");
}
?>

<html>
  <meta charset = "UTF-8" name="viewport" content="width=device-width">

  <head>
    <title>Campus Room</title>

    <!-- Latest compiled and minified CSS -->
   		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  </head>


  <body>
    <body background="wood-texture.jpg">
<div class="container">
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

    <h1>Campus room</h1>
    <h3>新規登録</h3>

    <!-- 登録フォーム -->
    <form name="touroku" method="post" action="">
        <!-- ユーザー名 -->
        <div class="form-group">
            <label for="name-input">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name-input" placeholder="">
        </div>
        <!-- 写真 -->
        <div class="form-group">
            <label for="picture-input">画像</label>
            <input type="file" name="image" class="form-control" id="image-input" placeholder="">
        </div>
        <!-- アドレス -->
        <div class="form-group">
            <label for="mail-input">メールアドレス</label>
            <input type="text" name="mail" class="form-control" id="mail-input" placeholder="">
        </div>
        <!-- パスワード -->
        <div class="form-group">
            <label for="password-input">パスワード</label>
            <input type="password" name="password" class="form-control" id="password-input" placeholder="">
        </div>
        <!-- パスワード確認 -->
        <div class="form-group">
            <label for="password-confirmation-input">パスワード確認</label>
            <input type="password" name="password-confirmation" class="form-control" id="password-confirmation-input" placeholder="">
        </div>
        <!-- 区分 -->
        <div class="form-group">
            <label for="student-input">区分</label>
            <input type="radio" name="student" value="univ" onClick="changeDisabled()" checked>大学生
            <input type="radio" name="student" value="high" onClick="changeDisabled()">高校生
            <input type="radio" name="student" value="more" onClick="changeDisabled()">その他
        </div>
        <!-- 大学名 -->
        <div class="form-group">
          <label for="daigaku-input">大学名 ※例:東京大学</label>
            <!-- <select id="daigaku">
              <option value="" >大学名をお選びください</option>
              <option value="waseda" >早稲田大学</option>
              <option value="keio" >慶応義塾大学</option>
              <option value="meiji" >明治大学</option>
              <option value="aogaku" >青山学院大学</option>
              <option value="rikkyo" >立教大学</option>
              <option value="chuo" >中央大学</option>
              <option value="hosei" >法政大学</option>
              <option value="gakushuin" >学習院大学</option>
            </select> -->
            <input type="text" name="daigaku" class="form-control" id="daigaku-input" placeholder="">
        </div>
        <!-- 学籍番号 -->
        <div class="form-group">
            <label for="gakuseki-input">学籍番号</label>
            <input type="text" name="gakuseki" class="form-control" id="gakuseki-input" placeholder="">
        </div>

        <input type="submit" class="btn btn-primary" value="登録">
    </form>



  <script type="text/javascript" src="test.js"></script>
    </div>
    </body>
    </body>
</html>
