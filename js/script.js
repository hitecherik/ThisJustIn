(function() {
	Hyphenator.run();
	vex.defaultOptions.className = "vex-theme-top";
	
	var topicMenu = $(".change-topic select");
	
	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});
	
	topicMenu.on("change", function(){
		if(topicMenu.val()==="custom") {
			vex.dialog.prompt({
				message: "Please enter an RSS feed URL. <span class='warning-text'><b>Warning:</b> this sets a cookie.</span>",
				placeholder: "RSS URL",
				callback: function(data){
					if(data && typeof data === "string"){
						window.location.href = "http://this-just-in.tk/?topic=" + encodeURIComponent(data) + "&prevtopic=" + currentTopic;
					}
				}
			});
			
			topicMenu.val(currentTopic);
		} else {
			window.location.href = "http://this-just-in.tk/?" + $(".change-topic").serialize() + "&prevtopic=" + currentTopic;
		}
	});
	
	$("#rssEdit").on("click", function(){
		vex.dialog.buttons.NO.text = "Remove RSS Feed";
		
		vex.dialog.prompt({
			message: "Please enter a new RSS feed.",
			placeholder: decodeURIComponent(currentTopic),
			callback: function(data){
				if(data && typeof data === "string"){
					window.location.href = "http://this-just-in.tk/?topic=" + encodeURIComponent(data) + "&prevtopic=" + currentTopic;
				} else if(data===false) {
					$.get("remove_feed.php", function(){
						window.location.href = "http://this-just-in.tk";
					});
				} else {
					topicMenu.val("tn");
				}
				
				vex.dialog.buttons.NO.text = "Cancel";
			}
		})
	});
	
	// old validation code
	/* $("#rssCreate form, #rssEdit form").on("submit", function(e){
		e.preventDefault();
		if($(this).find("input[name=topic]").val()===""){
			$(".no-url").empty().append("<p>You have not entered a URL. You need to enter a URL to view your RSS feed.</p>");
		} else {
			window.location.href = "http://this-just-in.tk/?" + $(this).serialize() + "&prevtopic=" + currentTopic;
		}
	}); */
	
	$(".search-news .close").on("click", function(){
		$(this).parent().find("input").val("").get(0).focus();
	});
	
	if(IE){
		$(".posts a").attr("target", "_self");
	}
})();