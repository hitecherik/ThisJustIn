(function() {
	Hyphenator.run();
	vex.defaultOptions.className = "vex-theme-top";
	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});	
	if(IE){
		$(".posts a").attr("target", "_self");
	}
	
	var topicMenu = $(".change-topic select");
	
	function customFeedDialog(message, topicVal, auxTopic){
		vex.dialog.open({
			message: "Please enter an RSS feed URL. " + message,
			input: "<input type='url' name='rssurl' placeholder='RSS URL' required='required'>",
			callback: function(data){
				if(data.rssurl && typeof data.rssurl === "string"){
					window.location.href = "http://this-just-in.tk/?topic=" + encodeURIComponent(data.rssurl) + "&prevtopic=" + currentTopic;
				} else if(auxTopic) {
					removeRSSFeed(auxTopic);
				} else {
					topicMenu.val(currentTopic);
				}
			},
			afterOpen: function(){
				if(IE){
					$(".vex-content input").blur();
				} else {
					$(".vex-content input").first().focus();
				}
			}
		});
		
		topicMenu.val(topicVal);
	}
	
	function removeRSSFeed(topic){
		$.get("remove_feed.php", function(){
			if(topic){
				window.location.href = "http://this-just-in.tk/?topic=" + topic;
			} else {
				window.location.href = "http://this-just-in.tk";
			}
		});
	}
	
	topicMenu.on("change", function(){
		if(topicMenu.val() === "custom") {			
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
		vex.dialog.open({
			message: "Please enter a new RSS feed.",
			input: "<input type='url' name='rssurl' placeholder='" + decodeURIComponent(currentTopic) + "' required='required'>",
			callback: function(data){
				if(data.rssurl && typeof data.rssurl === "string"){
					window.location.href = "http://this-just-in.tk/?topic=" + encodeURIComponent(data.rssurl) + "&prevtopic=" + currentTopic;
				}
			},
			afterOpen: function(){
				if(IE){
					$(".vex-content input").blur();
				} else {
					$(".vex-content input").first().focus();
				}
			}
		})
	});
	
	$(".rssRemove").on("click", function(){
		vex.dialog.confirm({
			message: "Are you sure you want to remove this RSS feed? <span class='warning-text'>This action is not reversable.</span>",
			className: "vex-rss-remove vex-theme-top",
			callback: function(data){
				if(data){
					removeRSSFeed();
				}
			}
		});
	});
	
	$(".search-news .close").on("click", function(){
		$(this).parent().find("input").val("").get(0).focus();
	});
})();
