<?php
sleep(20);

		$idvideo = $_POST['name'];
		foreach(glob("SaveImage/".$idvideo."/*.png") as $n => $file) {
		    $new = 'SaveImage/' . $idvideo . '/img' . sprintf("%04d", $n + 1) . '.png';
		    rename($file, $new);
		}
		$full_command = 'ffmpeg -i nhac/'.rand(1, 13).'.mp3 -framerate 1/5 -i SaveImage/' . $idvideo. '\/img%04d.png -vf "scale=iw:ih" -c:v libx264 -c:a aac -strict experimental -b:a 192k -shortest -preset ultrafast saveVideo/'.$idvideo.'.mp4';
		exec($full_command .' >/dev/null 2>saveVideo/log_'.$idvideo.'.txt');
		exec('rm -rf SaveImage/'.$idvideo);
		echo 'saveVideo/'.$idvideo.'.mp4';