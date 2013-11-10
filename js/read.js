(function() {
	var allImgs = $(".article-content img").get(),
		loader = $(".loader");

	vex.defaultOptions.className = "vex-theme-top";

	$(document).ready(function(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 0);
	});

	for(var i = 0; i < Math.ceil(allImgs.length/2); i++){
		var j = (i * 2) + 1;

		$(allImgs[j]).addClass("even-img");
	}

	$(window).on("resize", function(){
		if($(window).width()>767){
			loader.css({
				top: ($(window).height() / 2) - (loader.height() / 2),
				left: ($(window).width() / 2) - (loader.width() / 2)
			});
		} else {
			loader.css({
				top: 0,
				left: 0
			});
		}
	});

	$(window).trigger("resize");


	function displayLoader(){
		if(navigator.standalone){
			loader.show();
		}
	}

	function changePage(url){
		window.location.href = url;
		displayLoader();
	}
	
	$(".finished-reading").on("click", function(){
		if(IE || shared || navigator.standalone){
			changePage("http://tji.eu5.org/?topic=" + backTopic);
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
	
	$(".mailSend").on("click", function(){
		vex.dialog.open({
			message: "Share by email",
			input: '<input type="email" name="emailTo" placeholder="Send this email to..." required="required"><input type="email" name="emailFrom" placeholder="Send this email from..." required="required"><input type="text" name="nameFrom" placeholder="My name is..." required="required"><input type="checkbox" name="cc" value="true"> Send a copy to me too!',
			callback: function(data){
				if(data!==false){
					var cc = (data.cc ? "true" : "false");
					
					$.get("send_email.php?emailTo=" + encodeURIComponent(data.emailTo) + "&emailFrom=" + encodeURIComponent(data.emailFrom) + "&nameFrom=" + encodeURIComponent(data.nameFrom) + "&url=" + encodeURIComponent(article.url) + "&cc=" + cc + "&excerpt=" + encodeURIComponent(article.excerpt) + "&title=" + encodeURIComponent(article.title), function(){
						vex.dialog.alert("Email successfully sent!");
					});
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
	
	$("a").on("click", function(){
		displayLoader();
	});
})();
