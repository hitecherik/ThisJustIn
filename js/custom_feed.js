(function(){
	$(".remove-feed").on("click", function(){
		$.get("remove_feed.php", function(){
			window.location.href = "http://this-just-in.tk";
		});
	});
	
	if(invalidFeed){
		$("#rssCreate").modal("show");
		$(".close-rssCreate").on("click", function(){
			$.get("remove_feed.php", function(){
				window.location.href = "http://this-just-in.tk/?topic=" + prevTopic + "&prevtopic=" + prevTopic;
			});
		});
		$("#rssCreate").on("show.bs.modal", function(){
			topicMenu.val(prevTopic);
		});
	}
})();