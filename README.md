### Campus

## 要件
- ユーザー登録(name,*picture, email, pass,学生区分,大学名,学籍)
- ログイン(name, pass)
- 記事投稿
- 投稿記事一覧
- 記事詳細
- マイページ
- ランキング
- 検索
*未対応です

## 構成

- 登録: user-register.php  
- ログイン: login.php
- ホーム: index.php
- 一覧: article.php
- 詳細: details.php
- 新規投稿: new-articles.php
- 検索: search.php  
- ランキング: ranking.php  
- ユーザー検索結果: user-result.php
- 大学検索結果: daigaku-result.php
- テーマ検索結果: theme-result.php
- マイページ(自分の投稿): mypage.php
- マイページ(お気に入り): MyFavorates.php
- 新規投稿: new-articles.php
- DB情報はconfig.phpに定義
- 複数箇所で呼ばれる処理は関数に纏め、functions.phpに定義

## dependency
- CSSフレームワーク -> [Bootstrap](http://getbootstrap.com/)

## バージョン情報
- PHP 5.4 (C4SAと同じ)
- MySQL 5.5 (C4SAと同じ)

##投稿画像の格納フォルダ
- 同ディレクトリ内に"images"を作成

## DBの設定について
```connectDB()``` メソッドを使う場合は、config.phpに自身のDBの情報を書いてください。(C4SAの共有MySQLから確認する)

config.php

```
<?php
return [
    'db' => [
        'database' => ‘データベース名', // PHPMyAdminの画面左側のデータベース名
        'user' => 'ユーザー名, // C4SAの共有MySQLに書いてある
        'password' => 'パスワード', // C4SAの共有MySQLに書いてある
        'host' => 'ローカルIP' // C4SAの共有MySQLに書いてある
    ]
];
```

そして、使いたいファイルの上でfunctions.phpを読み込んであげれば使えます。

```

<?php
require_once('./functions.php');
$db = connectDB();

```

##DB
- membersテーブル
    -id
    -name
    -picture
    -mail
    -password
    -student(学生区分)
    -daigaku
    -gakuseki
    -created
    -modified
- articlesテーブル
    -id
    -user_id(=members.id)
    -pictures
    -created
    -modified
- favaratesテーブル
    -id
    -user_id(ログイン中のユーザー)
    -article.id
    -viewer.id(対象画像の投稿者)
    -points(=1)
    -created
    -modified
- themesテーブル
    -id
    -theme
    -created
    -modified
