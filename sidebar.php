<div class="settings-control">
	Settings <span class="chevron">&#x25BC;</span>
</div>
<div class="settings">
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
	
	<?php if($custom_feed){ ?>
		<p class="center"><button type="button" class="pure-button center-child rssEdit">Edit RSS Feed</button></p>
		<p class="center"><button type="button" class="pure-button center-child pure-button-custom rss-remove-button rssRemove">Remove RSS Feed</button></p>
	<?php } ?>
	
	<form action="#" method="get" class="pure-form background-visibility">
		<fieldset>
			<div class="center">
				<input type="checkbox" class="background-visible center-child" name="backgroundvisible" value="bg-check" <?php if($backgroundVisible){ ?>checked="checked"<?php } ?>>
				<label for="backgroundvisible" class="background-visible center-child"> Background</label>
			</div>
		</fieldset>
	</form>
</div>

<div class="about-section">
	<p>Read the four latest stories from any of our 10 news sections, or add your own custom RSS feed!</p>
	<p>Copyright &copy; <a href="http://hitecherik.net" target="_blank">Alexander Nielsen</a>, 2013, under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0</a> license.</p>
</div>