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
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//

    // お気に入り登録
    $db = connectDb();

	$imagenumber=$_POST["article_id"];
	var_dump($imagenumber);

$sql='SELECT * FROM articles WHERE id= :article_id';

	$statement = $db->prepare($sql);
    $statement->execute(['article_id' => $imagenumber]);
    $viewers= $statement->fetch(PDO::FETCH_ASSOC);

    var_dump($viewers);


    $sql = "INSERT INTO favarates(user_id, article_id, viewer_id, points) VALUES(:user_id, :article_id, :viewer_id, :points)";
    $statement = $db->prepare($sql);
    $result = $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':article_id' => $imagenumber,
        ':viewer_id' => $viewers['user_id'],
        ':points' => "1"
    ]);



    if (!$result) {
        var_dump($result);
        die('Database Error');
    }

    $_SESSION["success"] = "お気に入りに追加しました";
    // 一覧画面に遷移
    header("Location: index.php");
//}



?>
