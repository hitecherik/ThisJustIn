<?php
	$url = $_GET["url"];
	$shared = ($_GET["shared"] ? $_GET["shared"] : "false");
	$back_topic = $_GET["topic"];
	
	$readability = simplexml_load_file("https://www.readability.com/api/content/v1/parser?url=$url&token=9920ba4fb3dd2e28e5f04994d322c6ef81b21e7b&format=xml");
	
	$content = $readability->content;
	$title = $readability->title;
	$author = $readability->author;
	$rddme = $readability->short_url;
	$real_url = $readability->url;
	
	$excerpt = $readability->excerpt;
	
	$isgd = simplexml_load_file("http://is.gd/create.php?format=xml&callback=?&url=" . urlencode("this-just-in.tk/read.php?shared=true&url=$real_url"))->shorturl;
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="apple-mobile-wep-app-capable" content="yes">
	<title><?php echo $title; ?> :: This Just In</title>
	
	<link rel="apple-touch-icon-precomposed" href="/img/logo.jpg">
	<link rel="SHORTCUT ICON" href="img/logo.ico">
	
	<link rel="stylesheet" href="css/vendor.css">
	<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700'>
	<link rel="stylesheet" href="css/vex.css">
	<link rel="stylesheet" href="css/vex-theme-top.css">
	<link rel="stylesheet" href="css/style.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/modernizr.min.js"></script>
	<script src="js/vex.combined.min.js"></script>
	<script>
		var IE = false,
			article = {
				excerpt: "<?php echo str_replace('"', '\\"', $excerpt); ?>",
				url: "<?php echo $isgd; ?>",
				title: "<?php echo str_replace('"', '\\"', $title); ?>"
			},
			shared = <?php echo $shared; ?>,
			backTopic = "<?php echo $back_topic; ?>";
	</script>
	<!--[if lte IE 6]><script>IE = true;</script><![endif]-->
</head>
<body class="read-page">
	<p class="logo-wrap"><a href="/" class="img-link"><img src="img/logo.jpg" alt="" width="130"></a></p>
	
	<h1 class="article-title center"><?php echo $title; ?></h1>
	
	<div class="article-author" style="font-weight:bold;" align="center">
		<p class="center"><?php echo ($author!="None" ? "By $author" : ""); ?></p>
	</div>
	
	<div class="article-content clearfix">
		<?php echo $content; ?>
	</div>
	
	<div class="controls">
		<p>
			<button class="finished-reading pure-button pure-button-primary">Finished Reading</button>
			<a href="<?php echo $real_url; ?>" class="original-article pure-button">Original Article</a>
		</p>
		<p>
			<a href="http://www.instapaper.com/hello2?url=<?php echo $real_url; ?>" class="pure-button instapaper-button" role="button" target="_blank">Save to Instapaper</a>
			<a href="http://readability.com/save?url=<?php echo $rddme; ?>" class="pure-button readability-button pure-button-custom" role="button" target="_blank">Save to Readability</a>
			<a href="http://twitter.com/intent/tweet?url=<?php echo urlencode($isgd); ?>&text=<?php echo urlencode($title); ?>&related=hitecherik%3AThis+Just+In+creator" target="_blank" class="pure-button pure-button-custom tweet-button" role="button">Tweet</a>
			<a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $isgd; ?>" target="_blank" class="pure-button facebook-button pure-button-custom" role="button">Share on Facebook</a>
			<button class="pure-button mailSend">Send by Email</button>
		</p>
	</div>
	
	<script src="js/read.js"></script>
	<script src="js/placeholders.min.js"></script>
</body>
</html>
