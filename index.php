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

  
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="cleartype" content="on">
  
	<link rel="icon" href="data:@file/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURfR6Kf+IO/7Gov/17+VwIv7UuP+cW+p2Kft2H/93H/+yf/7r4P7j0f////99Kf/QsoKdZQUAAADdSURBVHjanJPbEsMgCETBCwSj9f//tqLJJOmgnXafjJysDKtAuBQBvhZqxBpoyJ+ANM0ArSGlnCxA/0Ny0ZdSdgMQTDWXQwYg5MslC3C3eslzwO8uYZw4+OyIOYRQDWBzJYVTEwctMTPAFm0H1CLoeuKAcK5ngHwDzolvdeGgWdHCQZK3Jqm2HRAyRy0Uc416xDnwLA9g7PrLwdMdkHTEpE1CazA7DmAAcWsfPMKAew+C/SJl7ns88ng0ySG5lnPoewCt/nHtYdjy/F1wz3n1cGDE/PPTgwZ80VuAAQCUXSnv3GzD4gAAAABJRU5ErkJggg==" type="image/png" />
	<link rel="apple-touch-icon-precomposed" href="data:@file/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURfR6Kf+IO/7Gov/17+VwIv7UuP+cW+p2Kft2H/93H/+yf/7r4P7j0f////99Kf/QsoKdZQUAAADdSURBVHjanJPbEsMgCETBCwSj9f//tqLJJOmgnXafjJysDKtAuBQBvhZqxBpoyJ+ANM0ArSGlnCxA/0Ny0ZdSdgMQTDWXQwYg5MslC3C3eslzwO8uYZw4+OyIOYRQDWBzJYVTEwctMTPAFm0H1CLoeuKAcK5ngHwDzolvdeGgWdHCQZK3Jqm2HRAyRy0Uc416xDnwLA9g7PrLwdMdkHTEpE1CazA7DmAAcWsfPMKAew+C/SJl7ns88ng0ySG5lnPoewCt/nHtYdjy/F1wz3n1cGDE/PPTgwZ80VuAAQCUXSnv3GzD4gAAAABJRU5ErkJggg==" type="image/png" />
	<link rel="shortcut icon" href="data:@file/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURfR6Kf+IO/7Gov/17+VwIv7UuP+cW+p2Kft2H/93H/+yf/7r4P7j0f////99Kf/QsoKdZQUAAADdSURBVHjanJPbEsMgCETBCwSj9f//tqLJJOmgnXafjJysDKtAuBQBvhZqxBpoyJ+ANM0ArSGlnCxA/0Ny0ZdSdgMQTDWXQwYg5MslC3C3eslzwO8uYZw4+OyIOYRQDWBzJYVTEwctMTPAFm0H1CLoeuKAcK5ngHwDzolvdeGgWdHCQZK3Jqm2HRAyRy0Uc416xDnwLA9g7PrLwdMdkHTEpE1CazA7DmAAcWsfPMKAew+C/SJl7ns88ng0ySG5lnPoewCt/nHtYdjy/F1wz3n1cGDE/PPTgwZ80VuAAQCUXSnv3GzD4gAAAABJRU5ErkJggg==" type="image/png" />
  
<script type="text/javascript">
function update(pos,file) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		var response = this.responseText;
		console.log(response);
		
		var res = response.split("|");
		document.getElementById('lastPlayed').href = '?play=' + res[1] + '&at=' + res[0];
		document.getElementById('lastPlayed').innerHTML = res[1] + ' at ' + new Date(res[0] * 1000).toISOString().substr(11, 8);
		
    }
  };
  xhttp.open("GET", "?update=" + pos + "&file=" + file, true);
  xhttp.send();
}

function changePos(obj, time) {
	console.log(obj, time);
	document.getElementById('daplayer').currentTime = document.getElementById('daplayer').currentTime + time;
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
	} else {
		echo 0;
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
	echo '<div stlye="font-size:20px;">Last played: <a id="lastPlayed" href="?play='.urlencode($splits[1]) . '&at=' . urlencode($splits[0]) . '">' . $splits[1] . " at " . gmdate("H:i:s", $splits[0]) . '</a></div><br />';
}

if(isset($_GET["play"])) {

echo '
<h3>'.$sfile.'</h3>
<audio id="daplayer" controls autoplay preload="metadata" style=" width:100%;" ontimeupdate="timeUpdate(this)">
	<source src="'.$sfile.'" type="audio/mpeg">
	Your browser does not support the audio element.
</audio>
<div style="width:90%; margin-left:5%;">
	<img onclick="changePos(this,-60)" style="float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAYAAABVy1Q8AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAUnSURBVHja3FpNbFVFFL63Vao0SlOwSm2TQkJAoEZj/ElkUX4KxgQXbvskELsiwQXBDSRtCeqOhWmqxp+KsjAujFjTuCx0UYFEmhhIqCVQjfxILa+QVKVp3/Uce24zHefMzP2b19uTfL2v982bmW/OmTk/9/pBEHhLShwReg5Q64SLA0K7AGOA+qVAaCtgClAErMo7ISTzJ44DuJ13QtsFMojxPBNqJRPDjkt5J7QNMCmQKeXZ5LYJZiaSySWhHYAJycyCvBJqlcwsyDOh7cyekZGLQ0E2M44M4hbgEReEHoj5252ArwE1NGHf0H45oI00dQdwgxbjDi1EWYNT3DN3DXtGhKrN34BRwA+ATsAWQFU5TG6H5DRtCZnazgIuAA4BnnRF6JmImgliag/32zHAE1kTwk3da5hMmgSv0r7zszS5SsBHEUmVYtwXv+u1PfLjHttI6tOI+2ga8CPgPK38PwYS8j3cX09l6YcqAB9H0BRGCo8BHgLUATYBCoDPAb9pNCeSugZ4NkvHiqQ+sCSFhFYy/aA57QP8xBARP2Mq35xl6FMh7KlSwlgO/dABTZAb/n8J0JhlcFopmF8phWgbzXHQcFiconEzSx/waP1QY35Ro+2HAScMpN7OOsFD8+thSMVJH1ADn2k0j3HgxqxTcG5PxU0fHgT0M6cfXr90USSpkJxv0nxoDfkulSmjP3vZRRnLl8wvacb6uibS+MJVoRE11Z1ixvodoyU85te6KgUjqU8A9ylSSFpV4hz3/iwIYfbaQpAd5jtJ8hxhcQYlLYXX79MmhGSGhRVTTaYihXEOMhrCOG91WoRaJDKB5aHhR8l1SJoVkXqIl5ISQiIDTOc6wacSTQpTrbEY81HAz8yYe5IS6tRs0pCweK9T0uReSuvDGkWR/jdp9lvm+O5IQ0NdjJZUhIqKdrKpDliM28MQ6k5Sl0M5AzhNplK0aD8mFFvEe02CubVY9DOp0BpKNf4JCWHk+irVyzyhQa/oieXglhmAk1MKQu8Le8hWZjXH+jyhDUynwxpC5ZLlioX1qW4x7xvGpVUPpdZbfFLH3C+KhG4xjRqpsMGdOK4Fo44G5rubIqFRZpJoiisWkXZqFOUsX+QQErrCbG4sx75o8PYu5QWmRDxJHOYJjYU3hH0UXndrTjnXLwq9xszxSugWQkIY3g8xqnyFsdvAsYYaaC6qrTFEHBZEwH2KxgF1VDD4IhfSRnMJFIvet8AZkWDt+Rwz0bekgNK1NNEcVIuJcz6rIvQX4KTE3KcfrqbgslyCY9dLZh5ecc5TKkIoXwFGGC1hdNxeBjLtNLZKOyM0Z6mWtVDe1FRY7nlzz1hdSSuNyT0MaLepy/mG4t5ExGAySXoyoZlHv3za6fKhZkVnYiX0Lp06WUnBW/g8t6RY1P89VjEleAWPfwiF1xkK/9MMYGupzxnNuIg3lD7EImPtMpAKKIbaFyZYMaWa+hi1GK+L68Q2BT/umR8Xhg+iOgBPe3YvUVRR2w76Ldev+Pm4rkPk4v/3xzdGMO8CDktHps+EQdNUmbkI+AVwnXxcmJyhP1kP2EyEljGhlDzOe4AjJkJRiiTtnv4tkiTvLeiegBdt/V+cqs/zFAgGjjBEY3pZEfIog8Wiyo0MNYR9H/IivtCUtC6HxfejlIeY3gax/X6M+oxV2E+rtr2S/MI33txLFKWImvmVflvw+HcZrAnZnnK28jjl/Fh7W0f5yyqh9ISnHb45/Dv5HCyTXQb8kcbg84SWkvwrwAAD/T/IhhqabAAAAABJRU5ErkJggg==" />
	<img onclick="changePos(this,-300)" style="margin-left:20px;float:left;" src="data:image/png;base64,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" />
	<img onclick="changePos(this,60)" style="margin-left:20px;float:right;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAYAAABVy1Q8AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAUZSURBVHja3JpJaBRBFIZ7YtwSXEhiXKKgguIWUcQFFInGYC4KevGQuHsS9CB6UXAUl4t4kBAV9+XgQUSNqOBF8RAXcEEUkQSNIu5xouCKTvtKX+uzrFddPV3dY+bB74yT6ar6+r2qevV6Eq7rOjllMQEVgcbFwhITUD9QC2hmrgCVgFKgD6BpuQL0SvQJehMVVNxArxHIg6rMFaA0vooQrMqFkEsTqDbQ9PYOJEO9sQWVTSBXCr9W0IxcAHKl8Ktqj4uCCohCVbYHoG6gFwyQDJVx+AmW/AgGn4e5WzGmPOJ9L1CB5pqENyb8/nHQPNCFbCWnnUFTQEnQeVAT6JNmvrg+3hKv74LOKRshVwZaDboJ+m4QUqZAdPOdEQdQH9AmZl6YDNoN6KkxUQGJWK8BPYwAgLspB3BRsQ5Ugo2rQsPUS+mAMLtBHaIIueE4TzgQ1Wef0ZPXQVdAXwPOn31BYIIAjQU9YgYuQzwBHQTVgkaCSkFdcNl+FcAze3D5t76xluPRWYaRwW6AFmNYqqzYB4i2tTMTGBOgAaB7jCforr4C96EwuVyazJm8TPcQHZCI3VM+k/8yhlXYbDtNwqxDmE1RB7TGB+YQqGvIbJu2u4ukP9aBRoDeau7k/gzupOqA572vDxNmJkBHFJ1678+COlqoKViZMyZAk3H/UIWG2FMGWTwPWYXhgA5rdvS5Fk+s9TbmjB/QYFyGVd45bfHEWmfbMxzQcs3GF7YqIzKFL6C9UcGogM5IXkmT/cZkED1BFSjVuWmzwQZsDagvyddkrTKEuUWuUR3L85yIjQJNYmA+Yz6nswoJxsUJn3BiNgq0gAG6A+quAbnIXCcXP+TrBipCtadNoPXMcn1Sc6eTmkXEGzj9LCl5chEerVOkfjAmjGcpUB0DVO8TaknGSyqglOJ7cqheDAvkTdRCJkTaNNdfAm0EzTHsT5yrbis+a5NukhsGKp+sQir7btBGm2Ffp/CVVnB2kDn0183WtLMQtMT59XjTM5H5nwNt84C+kobo3Slw/j8TJYGpis8fUs+kmItL/0OgIsabrynQc+bi/lHv7j61btm6YGlAZS8oUBPT0HAb+4NF6wEaxsA3UaBmZnKLku+ELHiH89BEHJNqYWqmQC3eByQmvdfZcWcwmlVuFjPGZmT4DSRS+0bGldU4l+L0kMvM52pmajQiw1/7T4Piyy42VBOzh1RWi2NR5YoNjmJDvQq6xjS6Ukoo47aBOAYVuBjzFRWQ2HmPSuSe+/th3pYtS+KZzZXG5uCYPzpMynMM9IDxksiOl2UBZhn2rfLOAxyzlHL/2wBXTH/vWP59jo9VYZ9cJWqpSaExgQVFrtjYytQNbFsFqUJxRc+ECZCDx+5WRdGEPvesjRCmBvtQPcbxbmq5SaGR2nxHXYv23n/D9L/IcuK5A9vm+nW5m2nywGuDD5SLOdRickjMxAqxjSaD/jaY1uU4267phP7/HtYmRhtm6J3xu+udPw/W/B57bvc7gid+/pPwPfFuAa2Vlkw5o0iQw6KoFt3FZfUZ2ScKsOg4FDQKgToxh0u5n62gdUEqpyb7QcrRPwm38bsE1a9JjPa/TH54MR4TQTcmNWKfTlRAXuyvxlCKykOi7TV4QnWiBvKsDMtYLY7+YbAb4O8t2GZZ2EJjGCvGfeEE6HFAT4nvPsFr52NboUrBpqucqfXGM78oNQ3B80sJKYeJ1U78Cvgp7jmi8Hgf9NLKQcoDyiX7IcAAOz478S1wV/8AAAAASUVORK5CYII=" />
	<img onclick="changePos(this,300)" style="float:right;" src="data:image/png;base64,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" />
</div>
<br />
<br />
<br />
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