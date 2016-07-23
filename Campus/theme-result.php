<?php

require_once('./functions.php');
session_start();

// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある


// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある

$thememonth=$_POST["theme"];
$sql=
'SELECT * FROM articles
WHERE theme=:themeid';

$statement = $db->prepare($sql);
$statement->execute(['themeid'=> $thememonth]);

//var_dump($thememonth);
$articles = [];

foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $article ) {
  // $sql='SELECT name FROM members WHERE id= :id';
  // $statement = $db->prepare($sql);
  // $statement->execute(['id' => $article['user_id']]);
  // $members= $statement->fetch(PDO::FETCH_ASSOC);
    $articles[]= ['pictures' => $article['pictures'], 'themeid' => $article['theme']];
}

// var_dump($articles);
// var_dump($statement);
$sql1=
'SELECT theme FROM themes
WHERE id=:themeid';

$statement1 = $db->prepare($sql1);
$statement1->execute(['themeid'=> $thememonth]);
$articles1 = [];

foreach ($statement1->fetchAll(PDO::FETCH_ASSOC) as $article1 ) {
    $articles1[]= ['theme' => $article1['theme']];
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
              <li><a href="./new-articles.php">投稿</a></li>
              <li><a href="./search.php">検索</a></li>
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

  <!-- 検索結果 -->
  <h4><?php echo $article['theme'];?> 月のテーマ 「<?php echo $article1['theme'];?>」 の写真</h4>

  <?php foreach ($articles as $article ) {?>
      <img src="<?php echo 'images/'.$article['pictures'];?>" width="320" height="240" class="img-rounded img-responsive" alt="Responsive image">
      <?php echo $article['name'];?>
  <?php  }?>

  </div>
  </body>
  </html>
