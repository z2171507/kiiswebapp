<?php
require 'password.php';   // password_hash()��php 5.5.0�ȍ~�̊֐��̂��߁A�o�[�W�������Â��Ďg���Ȃ��ꍇ�Ɏg�p
// �Z�b�V�����J�n
session_start();

require 'dbinfo.php';

// �G���[���b�Z�[�W�A�o�^�������b�Z�[�W�̏�����
$errorMessage = "";
$signUpMessage = "";

// ���O�C���{�^���������ꂽ�ꍇ
if (isset($_POST["signUp"])) {
    // 1. ���[�UID�̓��̓`�F�b�N
    if (empty($_POST["password"])) {
        $errorMessage = '�p�X���[�h�������͂ł��B';
    } else if (empty($_POST["password2"])) {
        $errorMessage = '�m�F�p�p�X���[�h�������͂ł��B';
    } else if ($_POST["password"] != $_POST["password2"]){
	$errorMessage = '�p�X���[�h����v���Ă��܂���B';
    } else{
        // ���͂������[�U���ƃp�X���[�h���i�[
        $username = $_POST["username"];
        $password = $_POST["password"];

        // 2. ���[�U���ƃp�X���[�h�����͂���Ă�����F�؂���
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. �G���[����
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO userpage(gakusekinumber, password) VALUES (?, ?)");

            $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // �p�X���[�h�̃n�b�V�������s���i����͕�����݂̂Ȃ̂�bindValue(�ϐ��̓��e���ς��Ȃ�)���g�p�����A����excute�ɓn���Ă����Ȃ��j
	    
            $signUpMessage = '�o�^���������܂����B';
        } catch (PDOException $e) {
            $errorMessage = '�f�[�^�x�[�X�G���[';
            // $e->getMessage() �ŃG���[���e���Q�Ɖ\�i�f�o�b�O���̂ݕ\���j
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
	    <title>��B����w</title>
	    <link rel="stylesheet" href="stylesheet.css">
	    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
	    <script src="index.js" type="text/javascript"></script>
    </head>
    <body>
	<div id="header"></div>
	<div class="body"></div>
	<div class="grad"></div>
	<div class="title">
        	<div>�V�K�o�^���</div>
	</div>
	<br>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <div class="login">
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <input type="text" id="username" name="username" placeholder="�w�Дԍ������" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <input type="password" id="password" name="password" value="" placeholder="�p�X���[�h�����">
                <br>
                <input type="password" id="password2" name="password2" value="" placeholder="�ēx�p�X���[�h�����">
                <br>
                <input type="submit" id="signUp" name="signUp" value="�V�K�o�^">
		<br>
		<br>
		<a href="Login.php">�߂�</a>
            </div>
        </form>
	</div>
	<div id="footer"></div>
    </body>
</html>