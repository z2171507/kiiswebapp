<?php
session_start();

if (isset($_SESSION["username"])) {
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
    <head>
            <meta charset="utf-8">
	    <title>九州情報大学</title>
	    <link rel="stylesheet" href="stylesheet.css">
	    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
	    <script src="index.js" type="text/javascript"></script>
    </head>
    <body>
        <h1>ログアウト画面</h1>
	<div>ログアウトしました。</div>
        <ul>
            <li><a href="Login.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</html>