<?php

// セッション開始
session_start();

require 'dbinfo.php';
$username = $_SESSION["username"];
$button = array();

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// 登録ボタンが押された場合
if (isset($_POST["create"])) {
	//ボタンの値を格納
	for($i=1;$i<=6;$i++){
		switch($_POST["menu".$i.""]){
			case "bus":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "pcc":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "webmail":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "timetable":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "time":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "recruit":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "club":
        			$button[] = $_POST["menu".$i.""];
				break;
			case "library":
        			$button[] = $_POST["menu".$i.""];
				break;
			default:
				break;
		}
	}
	$val = array_unique($button);
	$button = array_values($val);
	for($i=1;$i<=6;$i++){
	if(!isset($button[$i])){
		$button[$i]="";
	}
	}

        // 2. ユーザ名とパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("UPDATE userpage SET button1 = :button1, button2 = :button2, button3 = :button3, button4 = :button4, button5 = :button5, button6 = :button6 WHERE gakusekinumber = :username;");

            $stmt->execute(array(':button1' => $button[0],':button2' => $button[1],':button3' => $button[2],':button4' => $button[3],':button5' => $button[4],':button6' => $button[5],':username' => $username));

        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
        }
	header('Location: UserPage.php');
	exit;
}


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
    <div id="header">
    </div>

    <div class="main">
<!--	<div class="body-index"></div>  -->
	<h1><img class="logo" src="./img/logo.png">ユーザーページ作成画面</h1>
	<form action="" method="post">
	<?php for($i=1;$i<=6;$i++){ ?>
		<div class="mainbox" style="height:140px; width:140px; padding: 10px; margin-bottom:10px; border: 1px dashed rgb(185, 55, 255);">

		<p>使用したいボタンを選んでください<br>
		<select name="menu<?php echo $i; ?>">
		<option value="bus">バス時刻表</option>
		<option value="pcc">PCC</option>
		<option value="webmail">ウェブメール</option>
		<option value="timetable">時間割</option>
		<option value="time">施設営業時間案内</option>
		<option value="recruit">就活情報</option>
		<option value="club">サークル掲示板</option>
		<option value="library">図書館掲示板</option>
		</select></p>
		</div>
	<?php } ?>
		<br>
		<input type="submit" name="create" value="登録">
	</form>
	<form action="UserPage.php">
		<input type="submit" value="キャンセル">
	</form>
	<a href="index.php">ホームへ戻る</a>
    </div>
    <div id="footer">
    </div>

  </body>
</html>