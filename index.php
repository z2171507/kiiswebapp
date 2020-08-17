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
		<div class="body-index"></div>
		<h1 class="login-title"><img class="logo" src="./img/logo.png">重要なお知らせ</h1>
		<?php
			require_once("./phpQuery-onefile.php");
			$html = file_get_contents("https://www.kiis.ac.jp/");
			$phpobj=phpQuery::newDocument($html);
			$link1 = $phpobj[".important-list > ul > li > time"];
			$link2 = $phpobj[".important-list > ul > li > a"]; 
		?>
		<div class="important">
			<ul>
				<?php foreach ($link1 as $link1) {
					$time[] = pq($link1)->text();
				} ?>

					<?php foreach ($link2 as $link2) {
						$link[] = pq($link2)->attr("href");
						$text[] = pq($link2)->text();
					} ?>
					<?php for($i=0;$i<=9;$i++){ ?>
						<li><?php echo $time[$i]; ?>　<a class="important-info" href="<?php echo $link[$i]; ?>" target="_blank" rel="noopener noreferrer"><?php echo $text[$i]; ?></a></li>
					<?php } ?>
			</ul>
		</div>
	</div>

	<div id="footer"></div>



  </body>
</html>