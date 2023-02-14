<?php

	$keyword = urlencode($_POST['keyword']);
	$start = $_POST['start'];
	$page = $_POST['page'];
	$data = Curl('https://www.google.com/search?yv=2&q='.$keyword.'&start='.$start.'&asearch=ichunk&tbm=isch&ijn='.$page.'&tbs=islt:xga,imgo:1,isz:ex,ift:png');
	if(preg_match_all('#\\\"ou\\\":\\\"(.+?)\\\"#is', $data, $link)){
		$list = array_unique($link[1]);
		for($i = 0; $i <= count($list)-1; $i++){
			$_link = str_replace('\\', '', $list[$i]);
			echo '
			<div class="col-md-2" style=" margin-bottom: 20px; ">
				<div class="image">
					<img data-original="'.$_link.'" src="http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif" class="thumbnail" style="width: 100%; height: 100px; margin-bottom: 0px" />
				</div>
				<div class="text-center">
				<input type="checkbox" value="'.$_link.'">
				</div>
			</div>
			';
		}

	}

	function Curl($url){
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$uaa = $_SERVER['HTTP_USER_AGENT'];
		curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: $uaa");
		return curl_exec($ch);
	}
