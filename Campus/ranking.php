<?php

require_once('./functions.php');
session_start();

// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある

// DB接続
$db = connectDB(); // ※ この関数はfunctions.phpに定義してある
// 全記事を降順に取得するSQL文
$sql='SELECT * , SUM( favarates.points ) AS fav_counts
FROM favarates
INNER JOIN articles ON favarates.article_id = articles.id
INNER JOIN members ON favarates.viewer_id = members.id
GROUP BY favarates.article_id
ORDER BY fav_counts DESC ';
// // $rank = 'SELECT COUNT (*) FROM favarates GROUP BY article_id ORDER BY COUNT(*) DESC';
$statement = $db->query($sql);
// var_dump($statement);
// SQLを実行
$articles = [];

foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $article ) {
  $sql='SELECT id,name,daigaku FROM members WHERE id= :id';
  $statement = $db->prepare($sql);
  $statement->execute(['id' => $article['user_id']]);
  $members= $statement->fetch(PDO::FETCH_ASSOC);
  $articles[]= ['pictures' => $article['pictures'], 'name' => $article['name'], 'daigaku' => $article['daigaku'], 'id' => $article['id']];

}

// var_dump($articles);


//var_dump($hi);


//$query_sum=mysql_query($sql);
//$result_sum=mysql_fetch_array($query_sum);
//print $hi['COUNT(*)'];

// $articles
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
<div class="container">

    <div class="header clearfix">
        <nav>
            <ul class="nav nav-tabs">
              <li><a href="./index.php">ホーム</a></li>
              <li><a href="./articles.php">一覧</a></li>
              <li><a href="./new-articles.php">投稿</a></li>
              <li><a href="./search.php">検索</a></li>
              <li class="active"><a href="./ranking.php">ランキング</a></li>
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

    <h4>現在のランキング</h4>
	<?php $juni=1 ?>

    <?php foreach ($articles as $article ) {?>
  	<div class="panel panel-success">
        <div class="panel-heading"><?php echo $juni ?>位<?php $juni=$juni+1; ?></div>
        <div class="panel-body"><img src="<?php echo 'images/'.$article['pictures'];?>" width="320" height="240" class="img-rounded img-responsive" alt="Responsive image"></div>
    <div class="panel-footer">
      <?php echo $article['name'];?>
        <?php echo $article['daigaku'];?>
     </div>
  </div>
  <?php  }?>


</body>
</html>
