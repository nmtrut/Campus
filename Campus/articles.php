<?php

require_once('./functions.php');
session_start();
// ログインしていなかったら、ログイン画面にリダイレクトする
redirectIfNotLogin(); // ※ この関数はfunctions.phpに定義してある


// DB接続
$db = connectDB();

$sql='SELECT * , COUNT( favarates.points ) AS fav_counts
FROM articles
LEFT JOIN members ON articles.user_id = members.id
LEFT JOIN favarates ON articles.id = favarates.article_id
GROUP BY articles.id';

$statement = $db->query($sql);
// $articles
$articles = [];
foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $article ) {
  // $sql='SELECT id,name,daigaku FROM members WHERE id= :id';
  // $statement = $db->prepare($sql);
  // $statement->execute(['id' => $article['user_id']]);
  // $members= $statement->fetch(PDO::FETCH_ASSOC);
  $articles[]= ['fav_counts' => $article['fav_counts']];

}

$sql1='SELECT a.theme,a.id AS aid,a.user_id,a.pictures,t.theme,t.id FROM articles AS a
INNER JOIN themes AS t
ON a.theme=t.id';
$statement1 = $db->query($sql1);
// $articles
$articles1 = [];
foreach ($statement1->fetchAll(PDO::FETCH_ASSOC) as $article1 ) {
  $sql1='SELECT id,name,daigaku FROM members WHERE id= :id';
  $statement1 = $db->prepare($sql1);
  $statement1->execute(['id' => $article1['user_id']]);
  $members1= $statement1->fetch(PDO::FETCH_ASSOC);
  $articles1[]=
    ['pictures' => $article1['pictures'],
      'name' => $members1['name'],
      'daigaku' => $members1['daigaku'],
      'id' => $article1['id'],
      'aid' => $article1['aid'],
      'theme' => $article1['theme']];

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
              <li class="active"><a href="./articles.php">一覧</a></li>
              <li><a href="./new-articles.php">投稿</a></li>
              <li><a href="./search.php">検索</a></li>
              <li><a href="./ranking.php">ランキング</a></li>
              <li><a href="./mypage.php">マイページ</a></li>
              <li><a href="./logout.php">ログアウト</a></li>
            </ul>
      </nav>
      <h3 class="text-muted">Campus Room</h3>

  </div>


<div class="panel panel-primary">
    <?php $kaisu=1; ?>
<?php foreach ($articles1 as $article1 ) {?>

  <?php $shume=1; ?>
  <div class="panel-heading">
    <form action="user-result.php" method="post">
      <input type = "hidden" name ="name" value="<?php echo $article1['name']; ?>">
      <input type="submit" class="btn btn-info btn-sm" value="<?php echo $article1['name'];?>">
    </form>
    </div>

  <div class="panel-body">
    <img src="<?php echo 'images/'.$article1['pictures'];?>" width="320px" height="240px" class="img-rounded img-responsive" alt="Responsive image">
    </div>

  <div class="panel-footer">
  <form action="daigaku-result.php" method="post">
      <input type = "hidden" name ="daigaku" value="<?php echo $article1['daigaku']; ?>">
      <input type="submit" class="btn btn-warning btn-xs" value="<?php echo $article1['daigaku'];?>">
    </form>

    <form action="theme-result.php" method="post">
      <input type = "hidden" name ="theme" value="<?php echo $article1['id']; ?>">
      <input type="submit" class="btn btn-success btn-xs" value="<?php echo $article1['theme'];?>">
    </form>

    <?php foreach ($articles as $article ) {?>
      <?php if($kaisu == $shume) {?>
    	 <form action="favorates.php" method="post">
           <input type = "hidden" name ="article_id" value="<?php echo $article1['aid']; ?>">
           <input type="submit" class="btn btn-danger btn-sm" value="いいね:<?php echo $article['fav_counts'];?>">
        </form>

    <form action="details.php" method="get">
      <input type = "hidden" name ="detail" value="<?php echo $article1['aid']; ?>">
      <input type="submit" class="btn btn-link btn-xs" value="詳細">
    </form>

    </div>



      <?php  }?>
      <?php $shume = $shume+1;?>
    <?php  }?>
        <?php $kaisu = $kaisu+1 ?>


<?php  }?>
  </div>
	</div>

</body>
</html>
