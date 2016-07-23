<?php

require_once('./functions.php');
session_start();

// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある


// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある

$onepictures=$_GET["detail"];
$sql='SELECT * FROM articles WHERE id=:id';


$statement = $db->prepare($sql);
$statement->execute(['id'=> $onepictures]);

// $articles
$articles = [];

foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $article ) {
  // $sql='SELECT name FROM members WHERE id= :id';
  // $statement = $db->prepare($sql);
  // $statement->execute(['id' => $article['user_id']]);
  // $members= $statement->fetch(PDO::FETCH_ASSOC);
    $articles[]= ['pictures' => $article['pictures']];
}


//var_dump($articles);
//var_dump($statement);

?>

<html lang="ja">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>Campus Room</title>
    	<!-- Latest compiled and minified CSS -->
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
  <h3 class="text-muted">画像詳細</h3>
  <form class="form-horizontal">
    <div class="form-group">
      <?php foreach ($articles as $article ) {?>
          <img src="<?php echo 'images/'.$article['pictures'];?>" width="320" height="240" class="img-rounded img-responsive" alt="Responsive image">
      <?php  }?>
    </div>

    <div class="form-group">
    	<a href="https://twitter.com/share" class="twitter-share-button" data-text="Campus Room" data-size="large" data-hashtags="CampusRoom">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>

    <div class="fb-share-button" data-layout="button_count" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div>

  </form>
  </div>
  </body>
  </html>
