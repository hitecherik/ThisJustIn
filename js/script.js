(function() {
	Hyphenator.run();
	vex.defaultOptions.className = "vex-theme-top";
	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});
	
	var topicMenu = $(".change-topic select");
	
	function customFeedDialog(message, topicVal, auxTopic){
		vex.dialog.prompt({
			message: "Please enter an RSS feed URL. " + message,
			placeholder: "RSS URL",
			callback: function(data){
				if(data && typeof data === "string"){
					window.location.href = "http://this-just-in.tk/?topic=" + encodeURIComponent(data) + "&prevtopic=" + currentTopic;
				} else if(auxTopic) {
					removeRSSFeed();
					window.location.href = "http://this-just-in.tk/?topic=" + auxTopic;
				}
			}
		});
		
		topicMenu.val(topicVal);
	}
	
	function removeRSSFeed(){
		$.get("remove_feed.php", function(){
			window.location.href = "http://this-just-in.tk";
		});
	}
	
	topicMenu.on("change", function(){
		if(topicMenu.val()==="custom") {			
			customFeedDialog("<span class='warning-text'><b>Warning:</b> this sets a cookie.</span>", currentTopic);
		} else {
			window.location.href = "http://this-just-in.tk/?" + $(".change-topic").serialize() + "&prevtopic=" + currentTopic;
		}
	});
	
	if(invalidFeed){
		currentTopic = prevTopic;
		customFeedDialog("<span class='error-text'><b>Error:</b> you have entered an invalid feed.</span>", prevTopic, prevTopic);
	}
	
	$(".rssEdit").on("click", function(){
		vex.dialog.buttons.NO.text = "Remove RSS Feed";
		
		vex.dialog.prompt({
			message: "Please enter a new RSS feed.",
			escapeButtonCloses: false,
			overlayClosesOnClick: false,
			placeholder: decodeURIComponent(currentTopic),
			callback: function(data){
				if(data && typeof data === "string"){
					window.location.href = "http://this-just-in.tk/?topic=" + encodeURIComponent(data) + "&prevtopic=" + currentTopic;
				} else if(data===false) {
					removeRSSFeed();
				}
				
				vex.dialog.buttons.NO.text = "Cancel";
			}
		})
	});
	
	$(".search-news .close").on("click", function(){
		$(this).parent().find("input").val("").get(0).focus();
	});
	
	if(IE){
		$(".posts a").attr("target", "_self");
	}
	
	// old validation code
	/* $("#rssCreate form, #rssEdit form").on("submit", function(e){
		e.preventDefault();
		if($(this).find("input[name=topic]").val()===""){
			$(".no-url").empty().append("<p>You have not entered a URL. You need to enter a URL to view your RSS feed.</p>");
		} else {
			window.location.href = "http://this-just-in.tk/?" + $(this).serialize() + "&prevtopic=" + currentTopic;
		}
	}); */
})();