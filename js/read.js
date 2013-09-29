(function() {
	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});
	
	$(".finished-reading").on("click", function(){
		if(IE || shared){
			window.location.href = "http://this-just-in.tk/";
		} else {
			window.close();
		}
	});
	
	$("#mailSend form").on("submit", function(e){
		e.preventDefault();
		
		$.get("send_email.php?" + $(this).serialize() + "&url=" + encodeURIComponent(article.url) + "&excerpt=" + encodeURIComponent(article.excerpt) + "&title=" + encodeURIComponent(article.title), function(){
			$("#mailSend").modal("hide");
		});
	});
	
	if(!Modernizr.touch){
		$("#mailSend").on("shown.bs.modal", function(){
			var firstInput = $(this).find("input").first().get()[0];
			firstInput.focus();
		});
	}
})();