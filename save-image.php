<?php 

	$idvideo = $_POST['name'];
	copy($_POST['file'], 'SaveImage/'.$idvideo.'/'.rand(1, 10000).'.png');