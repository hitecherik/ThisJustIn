(function() {
	var topicMenu = $(".change-topic select"),
		loader = $(".loader"),
		settingsStatus = false;
	
	Hyphenator.run();

	vex.defaultOptions.className = "vex-theme-top";
	
	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});	
	
	if(IE || navigator.standalone){
		$(".posts a").attr("target", "_self");
	}
	
	function customFeedDialog(message, topicVal, auxTopic){
		vex.dialog.open({
			message: "Please enter an RSS feed URL. " + message,
			input: "<input type='url' name='rssurl' placeholder='RSS URL' required='required'>",
			callback: function(data){
				if(data.rssurl && typeof data.rssurl === "string"){
					changePage("http://tji.eu5.org/?topic=" + encodeURIComponent(data.rssurl) + "&prevtopic=" + currentTopic);
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
				changePage("http://tji.eu5.org/?topic=" + topic);
			} else {
				changePage("http://tji.eu5.org");
			}
		});
	}

	function displayLoader(){
		if(navigator.standalone){
			loader.show();
		}
	}

	function changePage(url){
		window.location.href = url;
		displayLoader();
	}
	
	topicMenu.on("change", function(){
		if(topicMenu.val() === "custom") {			
			customFeedDialog("<span class='warning-text'><b>Warning:</b> this sets a cookie.</span>", currentTopic);
		} else {
			changePage("http://tji.eu5.org/?" + $(".change-topic").serialize() + "&prevtopic=" + currentTopic);
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
					changePage("http://tji.eu5.org/?topic=" + encodeURIComponent(data.rssurl) + "&prevtopic=" + currentTopic);
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
	
	$(".settings-control").on("click", function(){
		var $this = $(this);
		$this.next(".settings").slideToggle();
		$this.find(".chevron").fadeOut(function(){
			var chevron = $this.find(".chevron").empty();
			
			if(settingsStatus){
				chevron.append("&#x25BC;").fadeIn();
				console.log("first");
			} else {
				chevron.append("&#x25B2;").fadeIn();
				console.log(chevron.html());
			}
			
			settingsStatus = !settingsStatus;
		});
	});

	$("a").on("click", function(e){
		if(navigator.standalone){
			e.preventDefault();
			changePage($(this).attr("href"));
		}
	});
})();
