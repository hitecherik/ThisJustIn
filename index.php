<?php
	include "get_feeds.php";
	
	$backgroundVisibleString = $_GET["backgroundvisible"];
	
	if($backgroundVisibleString =="background-visible" || $backgroundVisibleString=="background-invisible"){
		setcookie("TJI-BACKGROUND-VISIBLE", $backgroundVisibleString, time() + 31536000, "/", "tji.eu5.org");
	} else if(isset($_COOKIE["TJI-BACKGROUND-VISIBLE"])){
		setcookie("TJI-BACKGROUND-VISIBLE", $_COOKIE["TJI-BACKGROUND-VISIBLE"], time() + 31536000, "/", "tji.eu5.org");
		$backgroundVisibleString = $_COOKIE["TJI-BACKGROUND-VISIBLE"];
	} else {
		setcookie("TJI-BACKGROUND-VISIBLE", "background-visible", time() + 31536000, "/", "tji.eu5.org");
		$backgroundVisibleString = "background-visible";
	}
	
	$backgroundVisible = $backgroundVisibleString=="background-visible";
	
	$ie10 = strpos(get_browser(), "MSIE 10") != false;
?>
<!doctype html>
<html lang="en" <?php if(!$backgroundVisible){ ?>class="bg-invisible"<?php } ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<title>This Just In <?php echo ($top_news && $search ? "($search)" : ""); ?></title>
	
	<!-- iPhone --> <link href="img/startup/320.png" media="(device-width: 320px) and (device-height: 460px)" rel="apple-touch-startup-image">
	<!-- iPhone (retina) --> <link href="img/startup/640.png" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
	<!-- iPad (portrait) --> <link href="img/startup/768.png" media="(device-width: 768px) and (orientation: portrait)" rel="apple-touch-startup-image">
	<!-- iPad (landscape) --> <link href="img/startup/1024.png" media="(device-width: 768px) and (orientation: landscape)" rel="apple-touch-startup-image">
	<!-- iPad (retina portrait) --> <link href="img/startup/1536.png" media="(device-width: 1536px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
	<!-- iPad (retina landscape) --> <link href="img/startup/2048.png" media="(device-width: 1536px)  and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">

	<link rel="apple-touch-icon-precomposed" href="img/logo.png">
	<link rel="shortcut icon" href="img/logo.ico">

	<link rel="stylesheet" href="css/vendor.css">
	<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700'>
	<link rel="stylesheet" href="css/vex.css">
	<link rel="stylesheet" href="css/vex-theme-top.css">
	<link rel="stylesheet" href="css/style.css">
	<style>
		@media (max-width:850px) {
			<?php echo (!$top_news && !$custom_feed ? ".settings-control, .settings" : ".background-visibility"); ?> {
				display: none;
			}
		}
	</style>
	<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css"><![endif]-->
	<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css"><![endif]-->
	<!--[if !IE]> --><link rel="stylesheet" href="css/bg.css"><!-- <![endif]-->
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/modernizr.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/hyphenator.min.js"></script>
	<script src="js/vex.combined.min.js"></script>
	<script>
		var IE = <?php echo ($ie10 ? "true" : "false"); ?>,
			currentTopic = "<?php echo ($_GET["topic"] ? $_GET["topic"] : "tn"); ?>",
			prevTopic = "<?php echo $_GET["prevtopic"]; ?>",
			invalidFeed = <?php echo ($invalid_feed ? "true" : "false"); ?>;

		navigator.standalone = navigator.standalone || (screen.height - document.documentElement.clientHeight < 40);
		
		$(document).ready(function(){
			$(".desktop-only input.background-visible").val([<?php echo ($backgroundVisible ? "\"bg-check\"" : ""); ?>]);
		});
	</script>
	<!--[if lte IE 9]><script>IE = true;</script><![endif]-->
</head>
<body>
	<!--[if lte IE 8]>
		<div class="ie-header">
			Some features of this website may not work as you would expect them to. For the best possible experience, <a href="http://browsehappy.com">please upgrade to a more modern browser</a>.
		</div>
	<![endif]-->
	
	<a href="https://github.com/hitecherik/ThisJustIn" target="_blank" class="github img-link" title="Fork me on GitHub">Fork me on GitHub</a>
	
	<div class="pure-g-r">
		<div class="pure-u-1-5 sidebar">
			<p class="logo-wrap"><a href="/" class="img-link"><img src="img/logo-transparent.png" alt=""></a></p>
			
			<form action="" class="pure-form pure-form-stacked change-topic" method="get">
				<fieldset>
					<p class="center">
						<select name="topic" class="center-child">
							<optgroup label="Categories">
								<option value="tn" <?php echo ($_GET["topic"]=="tn" ? "selected='selected'" : ""); ?>>Top News</option>
								<option value="n" <?php echo ($_GET["topic"]=="n" ? "selected='selected'" : ""); ?>><?php echo $country_code; ?> News</option>
								<option value="w" <?php echo ($_GET["topic"]=="w" ? "selected='selected'" : ""); ?>>World News</option>
								<option value="b" <?php echo ($_GET["topic"]=="b" ? "selected='selected'" : ""); ?>>Business</option>
								<option value="tc" <?php echo ($_GET["topic"]=="tc" ? "selected='selected'" : ""); ?>>Technology</option>
								<option value="e" <?php echo ($_GET["topic"]=="e" ? "selected='selected'" : ""); ?>>Entertainment</option>
								<option value="s" <?php echo ($_GET["topic"]=="s" ? "selected='selected'" : ""); ?>>Sports</option>
								<option value="snc" <?php echo ($_GET["topic"]=="snc" ? "selected='selected'" : ""); ?>>Science</option>
								<option value="m" <?php echo ($_GET["topic"]=="m" ? "selected='selected'" : ""); ?>>Health</option>
								<option value="ir" <?php echo ($_GET["topic"]=="ir" ? "selected='selected'" : ""); ?>>Spotlight</option>
							</optgroup>
							<optgroup label="Custom Feed">
								<option value="<?php echo $custom_attr; ?>" class="custom-feed" <?php echo ($custom_feed ? "selected='selected'" : "");?>><?php echo $custom_name; ?></option>
							</optgroup>
						</select>
					</p>
				</fieldset>
			</form>
			
			<div class="desktop-only">
				<?php include "sidebar.php"; ?>
			</div>
		</div>

		<div class="pure-u-4-5 posts">
			<?php echo $output; ?>
		</div>
	</div>
	
	<div class="mobile-only">
		<hr>
		<?php include "sidebar.php"; ?>
	</div>

	<div class="loader">
		Loading...
	</div>
	
	<script src="js/script.js"></script>
	<!--[if IE 6]><script src="js/ie6.js"></script><![endif]-->
	<script src="js/placeholders.min.js"></script>
</body>
</html>
