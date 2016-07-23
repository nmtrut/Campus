<?php

require_once('./functions.php');
session_start();

// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある
// 全記事を降順に取得するSQL文
$myid=$_SESSION['user']['id'];
$sql = 'SELECT COUNT(*) FROM favarates WHERE viewer_id= :id';
// SQLを実行
$statement = $db->prepare($sql);
$statement->execute(['id'=> $myid]);
$hi= $statement->fetch(PDO::FETCH_ASSOC);

//var_dump($hi);

$sql = 'SELECT name FROM members WHERE id= :id';
$statement = $db->prepare($sql);
$statement->execute(['id'=> $myid]);
$hu= $statement->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT theme FROM themes where id= :id';
$statement = $db->prepare($sql);
$statement->execute(['id'=> date(n)]);
$mi= $statement->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT id,theme FROM themes';
$statement = $db->query($sql);
$articles = [];
foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $article ) {
    $articles[]= ['id' => $article['id'], 'theme' => $article['theme']];
}

//$query_sum=mysql_query($sql);
//$result_sum=mysql_fetch_array($query_sum);
//print $hi['COUNT(*)'];

// var_dump($articles);
// $articles = [];
//
// $result = $statement->execute([
//     'id' => $_SESSION['user']['id'],
//     ':article_id' => $imagenumber,
//     ':viewer_id' => $viewers['user_id'],
//     ':points' => "1"
// ]);


?>

<html lang="ja">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>Campus Room</title>

  	<!-- Latest compiled and minified CSS -->
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body>
 <body background="black.jpg">
<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-tabs">
              <li class="active"><a href="./index.php">ホーム</a></li>
              <li><a href="./articles.php">一覧</a></li>
              <li><a href="./new-articles.php">投稿</a></li>
              <li><a href="./search.php">検索</a></li>
              <li><a href="./ranking.php">ランキング</a></li>
              <li><a href="./mypage.php">マイページ</a></li>
              <li><a href="./logout.php">ログアウト</a></li>
            </ul>
        </nav>
        <h1 class="text-muted">Campus Room</h1>
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



  <p>ようこそ！ <?php print $hu['name']; ?> さん</p>
<p>現在の<?php print $hu['name']; ?>さんのいいねポイントは<?php print $hi['COUNT(*)']; ?>です</p>
<h2 class="text-muted">今月のテーマは　「<?php print $mi['theme']; ?>」 です！</h2>
  <h3><?php print date(Y) ?>年テーマ一覧</h3>
  <table class="table table-condensed table-hover table-bordered table-striped">
    <tr><th>月</th><td>テーマ</td></tr>
  <?php foreach ($articles as $article ) {?>
      <tr><th><?php echo $article['id'];?>月</th><td><?php echo $article['theme'];?></td></tr>
  <?php  }?>
</table>
</div>
</body>
</body>
</html>
