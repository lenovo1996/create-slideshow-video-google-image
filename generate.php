<?php

	$idvideo = substr(md5(rand(1, 10000000)), 0, 7);
	mkdir('SaveImage/'.$idvideo);
	echo $idvideo;