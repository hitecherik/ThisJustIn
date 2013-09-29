<?php
	include "get_feeds.php";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>This Just In <?php echo ($top_news && $search ? "($search)" : ""); ?></title>
	
	<link rel="apple-touch-icon-precomposed" href="img/logo.png" />
	<link rel="SHORTCUT ICON" href="img/logo.ico" />
	<link rel="stylesheet" href="css/vendor.css">
	<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700'>
	<link rel="stylesheet" href="css/style.css">
	<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css"><![endif]-->
	<!--[if lte IE 7]><link rel="stylesheet" href="css/ie7.css"><![endif]-->
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/modernizr.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/hyphenator.min.js"></script>
	<script>
		var IE = false,
			currentTopic = "<?php echo ($_GET["topic"] ? $_GET["topic"] : "tn"); ?>",
			prevTopic = "<?php echo $_GET["prevtopic"] . "\"" . ($custom_feed ? "," : ";") ?>
		<?php if($custom_feed){ ?>
			invalidFeed = <?php echo ($invalid_feed ? "true" : "false"); ?>;
		<?php } ?>
	</script>
	<!--[if lte IE 6]><script>IE = true;</script><![endif]-->
</head>
<body>
	<!--[if lte IE 8]>
		<div class="ie-header">
			Some features of this website may not work as you would expect them to. For the best possible experience, <a href="http://browsehappy.com">please upgrade to a more modern browser</a>.
		</div>
	<![endif]-->
	
	<div class="pure-g-r">
		<div class="pure-u-1-5 sidebar">
			<p class="logo-wrap"><a href="/" class="img-link"><img src="img/logo.jpg" alt="" width="130"></a></p>
			
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

			<?php if($top_news){ ?>
				<form action="#" class="pure-form pure-form-stacked search-news">
					<fieldset>							
						<p class="center">						
							<input class="center-child" name="q" type="text" placeholder="Search" value="<?php echo $search; ?>">
							<span class="close center-child">&times;</span>
						</p>
						<p class="center">
							<button type="submit" class="center-child pure-button pure-button-primary">Search</button>
						</p>
					</fieldset>
				</form>
			<?php } ?>
			
			<div class="desktop-only">
				<?php include "sidebar.php"; ?>
			</div>
		</div>

		<div class="pure-u-4-5 posts">
			<?php echo $output; ?>
		</div>
	</div>
	
	<div class="mobile-only">
		<?php include "sidebar.php"; ?>
	</div>
	
	<div class="modal" id="rssCreate" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">Add Custom RSS Feed</h2>
				</div>
				<div class="modal-body">
					<?php if($invalid_feed){ ?>
						<p class="error-text">The RSS feed you entered is not a valid XML document. Please enter a new feed URL.</p>
					<?php } else { ?>
							<p class="warning-text">Setting a custom RSS feed means that a <a href="https://en.wikipedia.org/wiki/HTTP_cookie" target="_blank">cookie</a> will be set in your browser. This cookie can only be accessed by this website for storing your RSS feeds. We do not store any of your cookie data on our servers.</p>
					<?php } ?>
					<form action="#" class="pure-form pure-form-aligned">
						<fieldset>
							<div class="pure-control-group">
								<div class="error-text no-url"></div>
								<label for="topic">RSS Feed URL:</label>
								<input type="url" name="topic">
							</div>
							<div class="pure-controls">
								<p><button type="submit" class="pure-button pure-button-primary">Add RSS Feed</button></p>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="pure-button close-rssCreate" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<?php if($custom_feed){ ?>
		<div class="modal" id="rssEdit" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title">Edit Custom RSS Feed</h2>
					</div>
					<div class="modal-body">
						<form action="#" class="pure-form pure-form-aligned">
							<fieldset>
								<div class="pure-control-group">
									<div class="error-text no-url"></div>
									<label for="topic">New RSS Feed URL:</label>
									<input type="url" name="topic" value="<?php echo $custom_attr; ?>">
								</div>
								<div class="pure-controls">
									<p><button type="submit" class="pure-button pure-button-primary">Change Custom Feed</button></p>
									<p><button type="button" class="pure-button remove-feed">Remove Custom Feed</button></p>
								</div>
							</fieldset>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="pure-button" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<script src="js/script.js"></script>
	<?php if($custom_feed){ ?>
		<script src="js/custom_feed.js"></script>
	<?php } ?>
	<!--[if IE 6]>
		<script src="js/ie6.js"></script>
	<![endif]-->
	<script src="js/placeholders.min.js"></script>
        
</body>
</html>