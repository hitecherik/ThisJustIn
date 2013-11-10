<?php
	function get_custom_name($input){
		$output;
		if(strlen($input)>17){
			$output = substr($input, 0, 14) . "...";
		} else {
			$output = $input;
		}
		return $output;
	}

	$topic = $_GET["topic"];
	$xml_feed;
	$invalid_feed = false;
	$top_news = $topic=="tn" || $topic=="";
	$search = ($top_news ? $_GET["q"] : "");
	$custom_feed = (substr($topic, 0, 4)=="http");
	$custom_attr = "custom";
	$custom_name = "Custom RSS Feed";
	$output = "";
	$countries = array("IL"=>"en_il","MY"=>"en_my","PK"=>"en_pk","PH"=>"en_ph","SG"=>"en_sg","AE"=>"ar_ae","LB"=>"ar_lb","SA"=>"ar_sa","VN"=>"vi_vn","BE"=>"nl_be","BW"=>"en_bw","CZ"=>"cs_cz","ET"=>"en_et","GH"=>"en_gh","IE"=>"en_ie","KE"=>"en_ke","HU"=>"hu_hu","MA"=>"fr_ma","NA"=>"en_na","NL"=>"nl_nl","NG"=>"en_ng","NO"=>"no_no","AT"=>"de_at","PL"=>"pl_pl","PT"=>"pt-PT_pt","CH"=>"de_ch","SN"=>"fr_sn","ZA" =>"en_za","SE"=>"sv_se","TZ"=>"en_tz","TR"=>"tr_tr","UG"=>"en_ug","GB"=>"uk","ZW"=>"en_zw","EG"=>"ar_eg","GR"=>"el_gr","RU" =>"ru_ru","RS"=>"sr_rs","UA"=>"ru_ua","AR"=>"es_ar","BR"=>"pt-BR_br","CL"=>"es_cl","CO"=>"es_co","CU"=>"es_cu","MX"=>"es_mx","PE" =>"es_pe","VE"=>"es_ve");
	$valid_topics = array("", "tn", "n", "w", "b", "tc", "e", "s", "snc", "m", "ir");
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$country_code_xml = simplexml_load_file("http://api.ipinfodb.com/v3/ip-country/?key=521a9858ab8592d5146539471cdbf52d3335e7302e4f7799f543b340a569255b&format=xml&ip=$ip");
	$country_code = $country_code_xml->countryCode;
	$country_code = (string)$country_code;
	if(array_key_exists($country_code, $countries)){
		$country = $countries[$country_code];
	} else {
		$country = strtolower($country_code);
	}
	
	if(isset($_COOKIE["TJI-CUSTOM-FEED"])){
		setcookie("TJI-CUSTOM-FEED", $_COOKIE["TJI-CUSTOM-FEED"], time() + 31536000, "/", "tji.eu5.org");
		$custom_attr = urldecode($_COOKIE["TJI-CUSTOM-FEED"]);
	}
	
	if(isset($_COOKIE["TJI-CUSTOM-NAME"])){
		setcookie("TJI-CUSTOM-NAME", $_COOKIE["TJI-CUSTOM-NAME"], time() + 31536000, "/", "tji.eu5.org");
		$custom_name = get_custom_name(urldecode($_COOKIE["TJI-CUSTOM-NAME"]));
	}
	
	if($topic=="tn"){
		$topic = "";
	}
	
	if($custom_feed){
		$xml_feed = simplexml_load_file($topic);
		setcookie("TJI-CUSTOM-FEED", $topic, time() + 31536000, "/", "tji.eu5.org");
		$custom_name = $xml_feed->channel[0]->title;
		setcookie("TJI-CUSTOM-NAME", $custom_name, time() + 31536000, "/", "tji.eu5.org");
		$custom_name = get_custom_name($custom_name);
		
		if(!$xml_feed){
			$invalid_feed = true;
		}
	} else {
		$xml_feed = simplexml_load_file("https://www.google.com/news?q=$search&output=rss&num=4&ned=$country&topic=" . $topic);
		
		if(!$xml_feed){
			$output = "<div class='error-text'><p class='hyphenate' lang='en'>Unfortunately, the current feed could not be fetched. Please <a href='javascript:window.location.reload()'>refresh the page</a> or try again later.</p></div>";
		} else if(!in_array($topic, $valid_topics)){
			$invalid_feed = true;
		}
	}
	
	$articles = $xml_feed->channel[0]->item;
	
	for($i = 0; $i < 4; $i++){
		$article = $articles[$i];
		$article_title = $article->title;
		$link = ($custom_feed ? $article->link : substr($article->link, strpos($article->link, "&url=") + 5));
		$new_title = "<b>";
		
		if(!$custom_feed){
			$arr = explode(" - ", $article_title);
			
			for($j = 0; $j < count($arr)-1; $j++){
				$new_title .= $arr[$j] . " - ";
			}
			
			$new_title .= "</b>" . $arr[count($arr)-1];
		} else {
			$new_title .= $article_title . "</b>";
		}
		
		$output .= "<p class='hyphenate' lang='en'><a href='read.php?topic=$topic&url=$link' target='_blank'>$new_title</a></p>";
	}
?>
