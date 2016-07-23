<?php
require_once('./functions.php');
session_start();

// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある


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
              <li><a href="./new-articles.php">投稿</a></li>
              <li class="active"><a href="./search.php">検索</a></li>
              <li><a href="./ranking.php">ランキング</a></li>
              <li><a href="./mypage.php">マイページ</a></li>
              <li><a href="./logout.php">ログアウト</a></li>
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

  <!-- 検索フォーム -->
  <h4>検索</h4>
      <!-- ユーザー名で検索 -->
      <form method="post" action="user-result.php">
        <div class="form-group">
            <label for="name-input">ユーザー名で検索</label>
            <input type="text" name="name" class="form-control" id="name-input" placeholder="">
        </div>
        <input type="submit" class="btn btn-primary" value="検索">
  　　　</form>

      <!-- 大学名で検索 -->
      <form method="post" action="daigaku-result.php">
        <div class="form-group">
            <label for="daigaku-input">大学名で検索</label>
            <input type="text" name="daigaku" class="form-control" id="daigaku-input" placeholder="">
        </div>
        <input type="submit" class="btn btn-primary" value="検索">
  　　　</form>

      <!-- テーマで検索 -->
      <form method="post" action="theme-result.php">
        <div class="form-group">
          <label for="theme-input">テーマで検索 ※月名を入力してください 例:1</label>
            <input type="text" name="theme" class="form-control" id="theme-input" placeholder="">
        </div>
        <input type="submit" class="btn btn-primary" value="検索">
    　　　</form>

  </div>
</body>
</html>
