<?php
require 'password.php';   // password_hash()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

require 'dbinfo.php';

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = '確認用パスワードが未入力です。';
    } else if ($_POST["password"] != $_POST["password2"]){
	$errorMessage = 'パスワードが一致していません。';
    } else{
        // 入力したユーザ名とパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ユーザ名とパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO userpage(gakusekinumber, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
	    
            $signUpMessage = '登録が完了しました。';
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
	header('Location: complete.html');
	exit;
    } 
}
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
	<div id="header"></div>
	<div class="body"></div>
	<div class="grad"></div>
	<div class="title">
        	<div>新規登録画面</div>
	</div>
	<br>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <div class="login">
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <input type="text" id="username" name="username" placeholder="学籍番号を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
		<br>
		<br>
		<a href="Login.php">戻る</a>
            </div>
        </form>
	</div>
	<div id="footer"></div>
    </body>
</html>