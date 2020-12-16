<?php

/*

a:Jdawg Mcgee
d:2020-12-13
v:0.1.3

Simple drop in MP3 Player that remembers the last file and position.

Just drop it into any folder with mp3s and head to the folder in your browser

*/

$root = getcwd();

$files_in_dir = glob("$root/*.mp3");

//********** Sort files here

//sort by file time
//usort($files_in_dir, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));

//sort by name
sort($files_in_dir);


if (isset($_GET['update'])) {
	if(!is_numeric($_GET['update'])) die(implode("|", explode("\n", file_get_contents("last.played"))));
	if(!file_exists(basename($_GET['file'], ".mp3") . ".mp3")) die(implode("|", explode("\n", file_get_contents("last.played"))));
	
	file_put_contents("last.played", $_GET['update'] . "\n" . $_GET['file']);
    die($_GET['update'] . "|" . $_GET['file']);
}

if(isset($_GET["play"])) {
	$sfile = substr($_GET["play"],0,256);
	if(!file_exists(basename($sfile, ".mp3") . ".mp3")) $sfile="";
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
<?

for($i=0;$i<count($files_in_dir);$i++) {
    $file = realpath($files_in_dir[$i]);
    $link = substr($file, strlen($root) + 1);
	if($link==$sfile) { //is it the current file?
		//store the previous file in a javscript var
			echo '
		var prev_file = "' . ($i>0 ? substr($files_in_dir[$i-1], strlen($root) + 1) : "") . '";';
		//store the next file in a javscript var
		echo '
		var next_file = "' . substr($files_in_dir[$i+1], strlen($root) + 1) . '";
';
		break;
	}

}

?>

		function update(pos,file) {
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				
				var res = response.split("|");
				document.getElementById('lastPlayed').href = '?play=' + res[1] + '&at=' + res[0];
				document.getElementById('lastPlayed').innerHTML = res[1] + ' at ' + new Date(res[0] * 1000).toISOString().substr(11, 8);
				document.title = 'Mp3 Player :: ' + res[1] + ' :: ' + new Date(res[0] * 1000).toISOString().substr(11, 8);
				
			}
		  };
		  xhttp.open("GET", "?update=" + pos + "&file=" + file, true);
		  xhttp.send();
		}

		function changePos(obj, time) {
			document.getElementById('daplayer').currentTime = document.getElementById('daplayer').currentTime + time;
		}

		positionTime = Date.now()/1000;
		
		function timeUpdate(event) {
			if((Date.now()/1000) - positionTime>5) {
				update(event.currentTime, '<? echo $sfile; ?>');
				positionTime = Date.now()/1000;
			}
		}

		function skipFile(file) {
			if(file!="") window.location.assign("?play="+encodeURI(file));
		}

		function fileEnded(obj) {
			window.location.assign("?play="+encodeURI(next_file));
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
	echo '		<div stlye="font-size:20px;">Last played: <a id="lastPlayed" href="?play='.urlencode($splits[1]) . '&at=' . urlencode($splits[0]) . '">' . $splits[1] . " at " . gmdate("H:i:s", $splits[0]) . '</a></div><br />';
}

if(isset($_GET["play"]) && $sfile != "") {

echo '
		<h3>'.$sfile.'</h3>
		<audio id="daplayer" controls autoplay preload="metadata" style=" width:100%;" ontimeupdate="timeUpdate(this)" onended="fileEnded(this)">
			<source src="'.$sfile.'" type="audio/mpeg">
			Your browser does not support the audio element.
		</audio>
		<div style="width:100%;">
			<img id="rwd30sc" onclick="changePos(this,-30)" style="float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAMAAABiFaQOAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURTAwMAAAANHR0enp6RYWFj8/P2BgYK+vr7+/v5+fn3BwcICAgE1NTY2Njff39////6qgJZAAAAAQdFJOU////////////////////wDgI10ZAAACjUlEQVR42uyWa6+kIAyGC+V+8///29MCCjo4Hjf7ZZMlM8boPNO+bWmB7Q8W/If+bSgLfA1l8R4i5jUUiRHlHcR2hPDWSSy/hRpTF6Toyi8gjOK8IOMjJEFcl4r45B5+UkL5J00rShh8iF6jNKiTNPmQJ9Sc3ILSmwEq+VARbKv5gx4+qLvaI2oXUfJuDfDF1pC6U6ncR8/HaNtdjp7/vZhO5ds8VW9gw82rXclONVlwU+JUr9hooaqt1NN1A5EASxFL6Dju9LXDvhDuFnL01bVyN/rG+tgOU1+g7Qxt6VC1DnkhX8IVcl3rDcS/1niFSstW+gIpe4X6jqZgLiEXxELTJpt/cgVRPSBTH1CBLuomenEF9fjFd1CoUHgHxZ5e2LJOKempcVBt2sAVa+cyOkOm2xyBEP3JXLCTewyFUb3DVNulVvUSmF9UTS1lem6+ctqEU3vtJZE36NV7+ODrXm1XVxG3g91dS5Dcbw8PoF999dIfG9buZQ57nrsougFBvyOnSRHfawGmRb1JgsJ5CrN/pDNoImgfUICj5g/4mpHuXahV7k6NhnPZnjAkHZdhwmlsuQp1/5opVqgJMjG6VgvcbPldN0Te1TLKU6NxVldBTmtSFiMbM9UNMxyCabT4qqmp6Zoia6om/dSZYSocRe5SxCqRah8DENLwk+zU+ONe5emgfPWzXbmKTFUJtjNpass9wTwl0XEi5+vmnFenYQOnyqYsLM4pGPa3/jxqjnMA+Mu5oYypFq9DLYzhGuXBFRnH1A6f43M+c4CJ3lqfzTzn42pQeyW+rPkkAaspuVjTgeDSlsdIvprJ5cuJBeMCux6NPvse+nTiVPL4m/MeuhySBtApZId/64j9I8AAw+KFwPQaa4sAAAAASUVORK5CYII=" />
			<img id="rwd1min" onclick="changePos(this,-60)" style="margin-left:10px; float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAMAAABiFaQOAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURQAAAEVFRTAwMBkZGdLS0oKCgr29venp6WVlZfn5+QEBAXd3d6Ojo5WVlQ8PD////w2IqD4AAAAQdFJOU////////////////////wDgI10ZAAACjElEQVR42pyX22LsIAhF8Yoadf7/bw+iScyFmXp8SNPGJYgbpPD5jwHiF4vrkDfrkK91GfIVli0RswwRk1ahxqxCnVmD2DdYg3ZmBRq+LUEnAyb+ETp8o1FL9hbjT2hm+KUa5Xz8Ck2+EcSv9EjaoQzZyQ5cDJoNJSgGeKE6aLLk3oVK85N+BBQCQdS0Ka1NHUR7aCuEfLZlMKLNwXR7FBdjhcOdqKEIzLoHkXRvBRmdHh4yiqWHlTxEQbAHNWnPqhEOFaV8Gh7Ogm1e876cBI19XVS+269WSvc+45oaUXEMIYiFhb255ROafmBernvhmYS5KyTIUAzpkbnq2JVUlom6Q76rq7xC6JvfcbtDHAs6qzcISTY855GxhS2R288SRozgs+1S8Y9qxILZ/+ixOYuzD2Qq3yHXFc6bdjQnUw2o9oxfC7p7WHLqgFoGQltcTadHWgnPPeEBaQbqtMWN99Qgp9o4C8fpnmuqURPUnW8Qqx62dwgu0DaEBPSWGP8DxHui9YGOrEEq/oaiYqh8YEjqlKcMoYH9cG0dr7zYN6gvT8cGn6hZh+G3pcATdWznFNKljogQmj0LYVht6vgBORh6bVDUrYAepiSIDA3vWEblzP4vUOiGyqgR2EPBv4tQgW4I98IyCk31cjO5X8flrHujEspUZ9LIEjivWwpHze9M5is87fkIRyXklVJ46VMwpP4V8vWqccd9l29VKGYzVjyPcsqVToF29uCipUrBLUWacu5M922/k9sdHVym4YLu0/nL9nZRl3pQex+wdwUtRuW9JbAapJGmhuDeRzgDj66FU8DFL/0eMna6xr6Ze0f1rHtZmclWMirjX1ps9CUorbVSoXhc+q/my/gnwADGS4ZXnZQ3BAAAAABJRU5ErkJggg==" />
			<img id="rwd5min" onclick="changePos(this,-300)" style="margin-left:10px; float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAMAAABiFaQOAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURQAAACwsLBQUFNHR0UBAQISEhGZmZr29vejo6Pr6+lNTUwEBAXh4eKamppubm////wkrDiIAAAAQdFJOU////////////////////wDgI10ZAAACr0lEQVR42pyXjbasKgiAFf9Qq3n/t70I6LRLp8517dVijC8QAd3m8z+GWb5x2IX3UALswmsoVYVIeAslMAI14SVEqgKx8A4i1cqQCK+gpsqQCm8gUSWoCy8gdokG7F14hjpjYAiPkLpEo3bhEfoyZghP0PDtPB6gKVPNT+js23kEXENuZodtwYYrKEczp2jS7iv3flEm4iIQRNWFh9VYtwj5H1v1bOkPdYnnjBKkpbtbpNHwsH7T6JCwki1cJOygYAgf5/UzJa/qST0E7IJ43agaVpCuC7ALJ/uyrFm5iwaVuwo8VzggJi4bC3vTGosIPIfApmpa972oLYwFmdol/HEN5agdtgk6VzQ+67ZMytiFXjmy18cNwpRKokFB2K5VlH3rG6bcoKAZRMvN+WpdXlJarKHJiSUZkiaQDTSwe4vt0X23/MF9AvmvTcpUcIcZiVo46OEK0bRHNtQgaEtojzB2j1IkXiEvWpRiDSoNaJpqfWP3GhS8L94fA+JRGErt52cGRZUGRCsxdglVhjZpNl9IHjOI12S25h5H3+c/C5tC2Y/oSUoBPkMIpm+uA90y9tp7v4T0846gbPn8is9riqxoc9unWOvw7xdEtatVaNSqNpqoEEygYDRfG6R1wqYCzUeYbi4Cq7UwtzQ6vtWvAar7HYpi6NAegRwK+c3NFI7PDTr4vJeE54RVU5C04lfXJTWkWa6dENL6yiga5dSW+bhtzXSfMzsf4eOwMaMT8pdqxDuCscpbTZtRhEEpY49LF8qH7e/C9VDb+pFHncUNLrtgZZb+tvvxueltiPMrhp1GiFbU+c02O6gP6JREVx/KwDG/EjhvlsO71YUqBzC3+weXQMg/7nvI2LiCiLtwvVHdjhrcC9TzZars+OaKjSnE4q31JYaE//RfzY/xnwADAO53fHkIrtfzAAAAAElFTkSuQmCC" />
	
			<img id="fwd30sc" onclick="changePos(this,30)" style="margin-left:10px; float:right;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAMAAABiFaQOAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURUVFRQAAANHR0ejo6BERETMzM2BgYK+vr7+/v5+fn3BwcICAgI2Njff39yEhIf///4Jl6WIAAAAQdFJOU////////////////////wDgI10ZAAACf0lEQVR42uyW6Y7cIAyADeYyJsn7v23NTWaSzHTbP5WKdqMI5gu+bTh+sOA/9I9DqNJPoFvqEbqj7qFNIMXfQxvq4ClD13e9Q1tg2NVY6QsIk1XnxfgBQjbqdVn9DNGu3hl8FA+d+o5ZIH1SZrf2lpmQnqLtjjRueMsMaDKWsEfEDdMh7LKZtI0wumMatEFjQH+fGqkxrlyDxOybq5nuTK7NiTHdbpTfzI1zm4OgqsM96CqtDF5BoVm6HYp+XuwCZT8b3l9B7aJ+JlCQf1uuPK6SCroOari5QfAINdOFNdrF1fERgtUKwxSATxDubxmaf238E9Rst3ojRPVBp1pA7JRO4gEz9QTx2XbVevwBigWKvwdV1/IfQrLhY44I/xpGBHmlAS3iVcvIzlvAVk3c0Mkdp6tqavhC0flAvgYtitaAOPSShGkmRsvvLJ4/y0AlV+szFCR0sInrBdJmTYwsgW1PKlLS+GT7vBZos6tS8mKV/E6EFo3yOyjrqnFdjx3oNml5K3pGEEIiUtzEkP8sAbV8qXaGke01zG12Wd3JkA45DAGX2hEK1OSrV2UNQSDHHKrLcx3NOjUz5MiGWfWKVsFDUSgAiGbM+TJXxHBTIJjCFi92bZpOnHUqV9JSsmAJHCPi7soVotYx6Tfa5Z0UzPxwK8swKCpy1meOIle0tL4xsNTyXpcNHRhy4q/PIwTq53ptNdS7U7yo9xj7KZ2bGo82SNvLXDHbN7+2zzh7M+vBbZpnK47vjZrXnu4SeU/s1ubNVyMBGfWwDF0PH9reM6e55TSxbOnmstm+rwYq5ItJZ3+dqd5GNyQ4cTsQfjMkYkgRrLUAMQX8WyP2LwEGACbmhfqzTo61AAAAAElFTkSuQmCC" />
			<img id="fwd1min" onclick="changePos(this,60)" style="margin-left:10px; float:right;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAMAAABiFaQOAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURQAAAEVFRTAwMBkZGdLS0oKCgr29venp6WVlZfn5+QEBAaOjo3d3d5WVlQ8PD////yWhsNkAAAAQdFJOU////////////////////wDgI10ZAAACi0lEQVR42pyWiZLDIAiG8b6iff+3XQWPpJFkp85Op5v0A0R+BD4/LGDfOP0LpOwPUCn2B0/AUY8QRz1CkaGeIYZ6Do+hniHYR/gGbal3aEPxUCBoR22h4LRNuUBfN+oOBWuEjPRjhvqGnJFxhLWgL+oKuUNdXMDJl2agpOIGICs+bCHnMZDlKjLMCdKSEPpQUs491S8XZkEa6xOtK5+0C/1w734WpFXLVsNkcueK2DADchJ91CTlcCujb6ZDQfQUCP1d5RumQ6af5Pk9Qi02Rk+6xLtNFCFs/HTIA+ZNhLvcdwxClnKg3F1PWwYhT5lLdxF6tu/pgo7EXbl7PwhlOsRvTbvIMQ0SrRROWXDWkkwCfwH0k8+TkYApDeHhqrEk7VEKtjLweqkldCQp31bgf8OAa8G6DWQw4T13hpLysfXDVJ+pprboO0Tl0E+kdqIJYQuTy+AVauuYeZiQRKBstjggs57M8GqsETc5G49oy4zwlqcrBBfoQPu+QgdC/j+Qx3o7KpQpe+EdCgKh/KH3cNIFD/XasRXS5VqvO4jCIPP12OqD1oji2hTvyeMPZWhV7rGpzPhYqHcaj9Kw1BLNG0T11vZRHwSJghquOAiHEYwOe0SG4fcJoiJA3cHoyXHokIEykCM3+l5mx4y5bCFHabVlQd2Sp4gZLYsg3Z616zjtmVQAk9X12NOZgCxF7zazi4/0FtL1UjNExajSVxcKSXWL6yhPWiEKpNGTC9pImijiSXNLyse4o+uf9CbVZbzs13CMF52uOHKZFMCcDgZT8n740BK4FaXmxpxg1H3IQQmY8DBQOaMuodEgYtzLvOeSUCdfUYnk/jOOOpu9kFIK4fOmkz+Now/rT4ABAF6ehhKswwzcAAAAAElFTkSuQmCC" />
			<img id="fwd5min" onclick="changePos(this,300)" style="float:right;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAABACAMAAABiFaQOAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURQAAACwsLBQUFNHR0UBAQISEhGZmZr29vejo6Pr6+lNTUwEBAXh4eKamppubm////wkrDiIAAAAQdFJOU////////////////////wDgI10ZAAACs0lEQVR42pyWWQKjIAxA2Qmg9v63HbJRp0DrDB8Wax4kIQvm9R/DTP94+QX/D5DLAunkEdSyQC0/hwxvATp5BrEw6OQZ1EgYdPIQImHQyUP1SBh08hAyqNipk/wUQuExyY+hZoxOJmoHfaW20G1M1AyZ9pP6hCDOzKTh3xAcs3K6l99ApzUL5YgxCZYQpJvPJqYs1fN2g+DffzFvSJh2X369zxvyGJ537AujEFhSrTvp0jASXSfdBlSq2BO8RHkXdTtGoCgMfnfqYp1s8sm725pOzAC3tGdAyZADahnp3kXBrXUTKLMPrB9RjqKgkzWU2L/nSI0kdW9lj0BicR35xMuD2+xD0MWHqLHfRBTajkGoYiiYwMvnXHMfgGlS9g0ALB1ilAMb25bypdV4jhb/CX1tamRSs6CQjX1IxgHpuah7kRwuvutQGDPTg9f5vqiFT4hPSU6kdghoI4TwLCw+4gzhOPg1sFSvIghVCgozdt9DNCpBGV9fb+gKoYYQh3o3CNPQLqHE+dOh424TSdFjCVG8Heg9yr9wO8odVAJBqF4mIxz8hsDJwRtOW42BI4SwhU4yqXvWvIqlgE2/bUpU5GzBKE9kFOv3DepXGMOrdyhzqYrqH4TcAuJ4Qzs6VLBQNt4KuxMWvMXh0mWE8w5rBMc5WSUOaucMSSW5pLAAu4LePcq56zVBF9V6Dniqe9e9sfaMX+Rddu+NpCxXrpb7ayEzWrKMNhrqM+5cMydV29F4pdWchldqCWYEUuOvWk+1qUWhjL0+qlC5rH6Ln+3z4C+IRT+44qM12iCPuVEf0tspvlI8+4jJSj9td+Z+JbicUuxdeQjjrvXlwwezHcHvrjklujbdWSgFYvlyoYLo7pc9VtdF+HHfg7O6217N1RN+X0cx+mKqwdpQU8zw6Ir9YPwRYAC5yHxhsOwjcwAAAABJRU5ErkJggg==" />
			<br />
			<img id="prev" onclick="skipFile(prev_file)" style="clear:both; float:left;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAA0CAMAAADypuvZAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURQAAAF9fX5KSksvLy6urq+np6SkpKTU1NdPT0/7+/js7OwEBAfLy8hcXFwUFBf///+ep9boAAAAQdFJOU////////////////////wDgI10ZAAAB00lEQVR42tyWyxLkIAhFfUQTNbH//29HxCgQdTGrqWGRqr7NQSQEVb+/MPXvQ8669uAWLqkF9ALIanOYQ1sJOaMvoaBXhZ6z2GNl1ENo4W5Khbwq5q1kvDqtiIJeFToBOq1cJ6l48XUyei2gGlUxyB0xqR1UmKgY9CprCPaTGAQr5z1Uc0uJQF1ZQZhJIhBRFlBoUVNPjzALCLOvO2pQqXXsyhzCWlOIKTPozUR1KNT305UJ1GpNIOyMHURr0KBbKF+oRiUeKlrMbSin7HK+n2JZS4V0eYNIraslbaQiIWO8iFoYoUgIPYjDo03kyjc9qxV38U6X33vIyex8+OT7gbQ1ngV+tIU3LSgGpaxxLVoIK5VP9by7ZxRbPX2nUbjFLrKWyrT3wIc4RVxd7XrvF5rPaFipzCBYK7NPA6i8/Z5+4HOOOsNHCJN1KIsZcUHk5oQzwhFlARWfPhMQKkp8leXcG3V+595QllDoffhCg9rM8tvg5B6z/FW2p4bxiZ8aNyo7CKqRGARKphCeRfz4vGAX9FBryv7Mhb3z0xG+ytHlTzUBFYprQ2n3iGJRXgmKD79bdKXeWA5XbHJjKX9MFVXTD/C4P3egEMJUUf/hfe+PAAMAzVhbok4nqHkAAAAASUVORK5CYII=" />
			<img id="next" onclick="skipFile(next_file)" style="float:right;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAA0CAMAAADypuvZAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAwUExURQAAAF9fX5KSksvLy6urq+np6SkpKTU1NdPT0/7+/js7OwEBAfLy8hcXFwUFBf///+ep9boAAAAQdFJOU////////////////////wDgI10ZAAAB2UlEQVR42tSWzbakIAyEAwjyp/3+bzsEEJPQcM+d1QyLXtSpDyppjMLnLxb8+5A1NnDVGh+ks7j6T4WM0pYbvNJZQsV16EOZB7rOI7OdzeUOeXpxlXUNyMHJPeZME1VcZbkBnXDzs3yEJPZBV1kngSDFwzII5tMnCCAST4WYsoBowgbxur7FSzUPgbiygBLJ06DEEn6Lxzw1XupnhU1NxTXqajV1pVNL6Knihd66FhCMhA8EJPMOqjeBQb3zK+ipPQ+IdGMJVU+5USZyBeuSkAMgJqxC3VKx8pa72qZhKn3WlGqd/wHCKrQSimunu6/x2s4panUxpe+zgwCUd1IxaQPVNDo4qdjNSdhjdxgaDxVtsKh190p+o7jidFZp3b26q58Z724xjUT6TP6mroTN3YPqsDFxZXf3OhPIhe3K9tG40cEejRvPWUPtPhfmfXJRwV1WDyGmLzfVvzOiKk77zYzA9LEleSA0dWU1wp6K3xFGlOWEdT39O2HdOGc5y7WY5VRZxCNJerz6n+6g+yRJWjymzFDELvkPf6k5pjRX6S+55TRb21Uo8zv3ukbfnje5VKqGy5DvCO7wk1JdZY14dvpmmJWqlTW+WEKWjlnpWsj5//h0+/X6I8AAlqtb+JPPyyEAAAAASUVORK5CYII=" />
		</div>
		<br /><br />
		<br /><br />
		<br /><br />
';

}


foreach ($files_in_dir as $file) {
    $file = realpath($file);
    $link = substr($file, strlen($root) + 1);
	echo '		<div style="vertical-align:middle; margin-top:8px; border:1px solid #aaa; padding:4px; background-color:'. ($link==$sfile ? 'lightgreen;' : 'none;'). '"><a href="?play='.urlencode($link).'" style="position:relative;top:-5px;font-size:20px;text-decoration:none;">'.basename($file).'</a></div>';
}


?>

		<br />
		<div style="vertical-align:middle;"><a href=".." style="font-size:20px;">Up</a></div>
		<br />
	</div>
</body>
</html>