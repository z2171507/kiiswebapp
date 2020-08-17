<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["username"])) {
    header("Location: Logout.php");
    exit;
}

require 'dbinfo.php';
$username = $_SESSION["username"];

// 2. ユーザ名とパスワードが入力されていたら認証する
$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);
// 3. エラー処理
try {
	$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

	$stmt = $pdo->prepare('SELECT * FROM userpage WHERE gakusekinumber = :username');
	$stmt->execute(array(':username'=>$username));

	if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                

                    foreach ($stmt as $row) {
                        $row['button1'];
                        $row['button2'];
                        $row['button3'];
                        $row['button4'];
                        $row['button5'];
                        $row['button6'];
                    }
		$button1 = $row['button1'];
		$button2 = $row['button2'];
		$button3 = $row['button3'];
		$button4 = $row['button4'];
		$button5 = $row['button5'];
		$button6 = $row['button6'];

	} 
	if($button1 == ""){
    		header("Location: PageCreate.php");
    		exit;
	}
}catch (PDOException $e) {
	$errorMessage = 'データベースエラー';
	// $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
	// echo $e->getMessage();
	}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>九州情報大学</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="index.js" type="text/javascript"></script>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>

    <div id="header"></div>

    <div class="main">
<!--	<div class="body-index"></div> -->
	<h1><img class="logo" src="./img/logo.png">ユーザーページ</h1>
	<?php for($i=1;$i<=6;$i++){ ?>
				<span class="mainbox"><div id="<?php echo ${'button'.$i}; ?>" style="height:140px; width:140px; padding: 1px; margin-bottom:10px; margin-right:5px; border: 1px dashed rgb(185, 55, 255);"></div></span>
	<?php } ?>
	<form class="PageCreate" action="PageCreate.php" method="post">
	<input type="submit" value="変更">
	</form>
	<a href="Logout.php">ログアウト</a>
    </div>

    <div id="footer"></div>

  </body>
</html>