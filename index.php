<?php

/*

a:Jdawg Mcgee
d:2020-12-03
v:0.1

Simple drop in MP3 Player that remembers the last file and position.

Just drop it into any folder with mp3s and head to the folder in your browser

*/

$root = getcwd();

if (isset($_GET['update'])) {
	if(!is_numeric($_GET['update'])) die ('0|null');
	if(!file_exists($_GET['file'])) die ('0|null');
	
	file_put_contents("last.played", $_GET['update'] . "\n" . $_GET['file']);
    die($_GET['update'] . "|" . $_GET['file']);
}

if(isset($_GET["play"])) {
	$sfile = substr($_GET["play"],0,256);
	if(!file_exists($sfile)) $sfile="";
}

?>
<html>
<head>
<title>Mp3 Player</title>
	<meta charset="utf-8">
	<meta name="description" content="">

  <!-- Mobile viewport optimization h5bp.com/ad -->
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="cleartype" content="on">
  
  <!-- Home screen icon  Mathias Bynens mathiasbynens.be/notes/touch-icons -->
	<link rel="icon" href="data:@file/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURfR6Kf+IO/7Gov/17+VwIv7UuP+cW+p2Kft2H/93H/+yf/7r4P7j0f////99Kf/QsoKdZQUAAADdSURBVHjanJPbEsMgCETBCwSj9f//tqLJJOmgnXafjJysDKtAuBQBvhZqxBpoyJ+ANM0ArSGlnCxA/0Ny0ZdSdgMQTDWXQwYg5MslC3C3eslzwO8uYZw4+OyIOYRQDWBzJYVTEwctMTPAFm0H1CLoeuKAcK5ngHwDzolvdeGgWdHCQZK3Jqm2HRAyRy0Uc416xDnwLA9g7PrLwdMdkHTEpE1CazA7DmAAcWsfPMKAew+C/SJl7ns88ng0ySG5lnPoewCt/nHtYdjy/F1wz3n1cGDE/PPTgwZ80VuAAQCUXSnv3GzD4gAAAABJRU5ErkJggg==" type="image/png" />
	<link rel="apple-touch-icon-precomposed" href="data:@file/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURfR6Kf+IO/7Gov/17+VwIv7UuP+cW+p2Kft2H/93H/+yf/7r4P7j0f////99Kf/QsoKdZQUAAADdSURBVHjanJPbEsMgCETBCwSj9f//tqLJJOmgnXafjJysDKtAuBQBvhZqxBpoyJ+ANM0ArSGlnCxA/0Ny0ZdSdgMQTDWXQwYg5MslC3C3eslzwO8uYZw4+OyIOYRQDWBzJYVTEwctMTPAFm0H1CLoeuKAcK5ngHwDzolvdeGgWdHCQZK3Jqm2HRAyRy0Uc416xDnwLA9g7PrLwdMdkHTEpE1CazA7DmAAcWsfPMKAew+C/SJl7ns88ng0ySG5lnPoewCt/nHtYdjy/F1wz3n1cGDE/PPTgwZ80VuAAQCUXSnv3GzD4gAAAABJRU5ErkJggg==" type="image/png" />
	<link rel="shortcut icon" href="data:@file/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURfR6Kf+IO/7Gov/17+VwIv7UuP+cW+p2Kft2H/93H/+yf/7r4P7j0f////99Kf/QsoKdZQUAAADdSURBVHjanJPbEsMgCETBCwSj9f//tqLJJOmgnXafjJysDKtAuBQBvhZqxBpoyJ+ANM0ArSGlnCxA/0Ny0ZdSdgMQTDWXQwYg5MslC3C3eslzwO8uYZw4+OyIOYRQDWBzJYVTEwctMTPAFm0H1CLoeuKAcK5ngHwDzolvdeGgWdHCQZK3Jqm2HRAyRy0Uc416xDnwLA9g7PrLwdMdkHTEpE1CazA7DmAAcWsfPMKAew+C/SJl7ns88ng0ySG5lnPoewCt/nHtYdjy/F1wz3n1cGDE/PPTgwZ80VuAAQCUXSnv3GzD4gAAAABJRU5ErkJggg==" type="image/png" />
  
<script type="text/javascript">
function update(pos,file) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		console.log(this.responseText);
    }
  };
  xhttp.open("GET", "?update=" + pos + "&file=" + file, true);
  xhttp.send();
}

positionTime = Date.now()/1000;

function timeUpdate(event) {
	if((Date.now()/1000) - positionTime>5) {
		update(event.currentTime, '<? echo $sfile; ?>');
		positionTime = Date.now()/1000;
	}
}

window.onload = function() {
	document.getElementById('daplayer').currentTime = <?
	if(isset($_GET["at"])) {
		if(is_numeric(substr($_GET["at"],0,256))) {
			echo $_GET["at"]*1;
		} else {
			echo 0;
		}
	}
	?>;
	
	document.getElementById('daplayer').play();
}
</script>
</head>
<body>
<div style="background:lightgray;padding:10px;">

<?

if(file_exists("last.played")) {
	$splits = explode("\n", file_get_contents("last.played"));
	echo '<div stlye="font-size:20px;">Last played: <a href="?play='.urlencode($splits[1]) . '&at=' . urlencode($splits[0]) . '">' . $splits[1] . " at " . $splits[0] . '</a></div><br />';
}

if(isset($_GET["play"])) {

echo '
<h3>'.$sfile.'</h3>
<audio id="daplayer" controls autoplay preload="metadata" style=" width:100%;" ontimeupdate="timeUpdate(this)">
	<source src="'.$sfile.'" type="audio/mpeg">
	Your browser does not support the audio element.
</audio><br />
<br />
<br />
';

}


$files_in_dir = glob("$root/*.*");

//********** Sort files here

//sort by file time
//usort($files_in_dir, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));

//sort by name
sort($files_in_dir);

foreach ($files_in_dir as $file) {
    $file = realpath($file);
    $link = substr($file, strlen($root) + 1);
	if(strpos(strtolower($file), ".mp3")==true) {
		echo '<div style="vertical-align:middle; margin-top:8px; border:1px solid #aaa; padding:4px; background-color:'. ($link==$sfile ? 'lightgreen;' : 'none;'). '"><a href="?play='.urlencode($link).'" style="position:relative;top:-5px;font-size:20px;text-decoration:none;">'.basename($file).'</a></div>';
	}
}

?>

<br />
<div style="vertical-align:middle;"><a href=".." style="font-size:20px;">Up</a></div>
<br />
</div>
</body>
</html>