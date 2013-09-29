(function() {
	Hyphenator.run();
	
	var topicMenu = $(".change-topic select");
	
	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});
	
	topicMenu.on("change", function(){
		if(topicMenu.val()==="custom") {
			$("#rssCreate").modal({
				backdrop: false
			});
		} else {
			window.location.href = "http://this-just-in.tk/?" + $(".change-topic").serialize() + "&prevtopic=" + currentTopic;
		}
	});
	
	$("#rssCreate").on("show.bs.modal", function(){
		topicMenu.val(currentTopic);
	});
	
	$("#rssCreate form, #rssEdit form").on("submit", function(e){
		e.preventDefault();
		if($(this).find("input[name=topic]").val()===""){
			$(".no-url").empty().append("<p>You have not entered a URL. You need to enter a URL to view your RSS feed.</p>");
		} else {
			window.location.href = "http://this-just-in.tk/?" + $(this).serialize() + "&prevtopic=" + currentTopic;
		}
	});
	
	$(".search-news .close").on("click", function(){
		$(this).parent().find("input").val("").get(0).focus();
	});
	
	if(!Modernizr.touch){
		$("#rssCreate, #rssEdit").on("shown.bs.modal", function(){
			var firstInput = $(this).find("input").first().get()[0];
			firstInput.focus();
		});
	}
	
	if(IE){
		$(".posts a").attr("target", "_self");
	}
})();