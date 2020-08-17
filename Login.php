<?php
require 'password.php';
// セッション開始
session_start();

require 'dbinfo.php';

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["username"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザー名が未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else{
        // 入力したユーザ名を格納
        $username = $_POST["username"];

        // 2. ユーザ名とパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM userpage WHERE gakusekinumber = :username');
            $stmt->execute(array(':username'=>$username));

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    foreach ($stmt as $row) {
                        $row['gakusekinumber'];  // ユーザー名
                    }
                    $_SESSION["username"] = $row['gakusekinumber'];
                    header("Location: UserPage.php");  // ユーザページ画面へ遷移
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザー名またはパスワードに誤りがあります。';
		    $passUpdate = 'パスワード変更';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザー名またはパスワードに誤りがあります。';
		$passUpdate = 'パスワード変更';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            //$e->getMessage();// でエラー内容を参照可能（デバッグ時のみ表示）
            //echo $e->getMessage();
        }
    }
}
unset($_SESSION["username"]);
?>

<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8">
	    <title>九州情報大学</title>
	    <link rel="stylesheet" href="stylesheet.css">
	    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
	    <script src="index.js" type="text/javascript"></script>
    </head>
    <body>
	<div id="header"></div>
	<div class="main">
	<div class="body"></div>
	<div class="grad"></div>
	<h1 class="login-title"><img class="logo" src="./img/logo.png">ログイン</h1>
	<br>
        <form id="loginForm" name="loginForm" action="" method="POST">
		<div class="login">
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <input type="text" id="username" name="username" placeholder="学籍番号を入力">
                <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <input type="submit" id="login" name="login" value="ログイン">
		<br>
		<br>
		<a href="SignUp.php">登録はコチラ</a>
		<?php if(isset($passUpdate)){ ?>
			<br>
			<a href="passUpdate.php"><?php echo $passUpdate; ?></a>
		<?php } ?>
		</div>
        </form>
        <br>
	</div>
	</div>
	<div id="footer"></div>
    </body>
</html>

