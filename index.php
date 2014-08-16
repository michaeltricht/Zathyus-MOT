/*
*	Members online today v3.1
*	By www.swordbeta.com, https://github.com/michaeltricht/Zathyus-MOT
*/
<?php
	error_reporting(0);
	include('config/database.php');
	//Mysql crap
	mysql_connect($config['database']['host'], $config['database']['username'], $config['database']['password']);
	mysql_select_db($config['database']['database']);
	//Okie, how are we doing?
	if($_GET['url']){
	if(preg_match("/\?s=/", $_GET['url'])){
		$_GET['url'] = explode("?s=", $_GET['url']);
		$_GET['url'] = $_GET['url'][0]."?act=idx";
	}
	//parse variables
		$user = mysql_real_escape_string(strip_tags(trim($_GET['user'])));
		if($user==$_GET['user']){
			$id = (int) $_GET['id'];
			$url = mysql_real_escape_string(strip_tags(trim(urldecode($_GET['url']))));
			$type = (int) $_GET['type'];
			//huhz delete dah old shiz
			if(isset($_GET['timezone']))
				@date_default_timezone_set(urldecode($_GET['timezone']));
			else
				date_default_timezone_set('Europe/Amsterdam');
			$date = date("j F Y");
			mysql_query("DELETE FROM `users` WHERE `date` != '$date'");
			//am I in there already?
			if($_GET['id'] && $_GET['user']){
				$q = mysql_query("SELECT * FROM `users` WHERE `user` = '$user' AND `uid` = '$id' AND `url` = '$url'") or die(mysql_error());
				if(mysql_num_rows($q)==0){
					mysql_query("INSERT INTO `users`(`uid`, `user`, `url`, `date`) VALUES('$id', '$user', '$url', '$date')")  or die(mysql_error());
				}
			}
		}else{die();}
		//k, fine, how many do we have now?
		$qu = mysql_query("SELECT * FROM `users` WHERE `date` = '$date' AND `url` = '$url'") or die(mysql_error());
		$count = mysql_num_rows($qu);
		//alrite, lets do this
		//LEEEEEEEEEEEEEROOOOOOOOOOOY JEEEEENKIIIINNSSSS
		?>
if(!img){
var img = "http://209.85.62.23/style_images/1/user.gif";
}
if(typeof(mot_breakline) == 'undefined'){
	var breakline = "<br />";
}else if(mot_breakline == 0){
	var breakline = "<br />";
}else{
	var breakline = "";
}
if(typeof(mot_boldnumber) == 'undefined'){
	var open_b = "";
	var close_b = "";
}else if(mot_boldnumber == 0){
	var open_b = "";
	var close_b = "";
}else{
	var open_b = "<b>";
	var close_b = "</b>";
}
		<?
		if($type==0){
			$url2 = explode("/index/", $url);
			$url2 = $url2[0];
		?>
//Created by Agent Moose, too lazy to figure out jquery
$("div#stats table.forums tr:contains('Board Statistics')").before("<tr><th colspan='2'>Members Online Today</th></tr><tr><td class='c_mark' id='motMarker'><img src='"+img+"'/></td><td>"+open_b+"<? echo $count; ?>"+close_b+"<?if($count<=1){echo " Member Online today.";}else{echo " Members Online today.";}echo "<br />";?>"+breakline+"<?$re = mysql_query("SELECT * FROM `users` WHERE `url` = '$url'") or die(mysql_error());$x = 1;while($ro = mysql_fetch_array($re)){echo "<a href='".$url2."/profile/".$ro['uid']."'>".$ro['user']."</a>";if($count!=$x){echo ", ";}$x=++$x;} ?></td></tr>")
		<?
		}else{
			$url2 = explode("/index.php", $url);
			$url2 = $url2[0];
		?>
c = document.getElementsByTagName("table");
for(x=0;x<c.length;x++){
	if(c[x].getElementsByTagName("td")[0].className=="pformstrip"){
		h = c[x].getElementsByTagName("tr")[0].cloneNode(true);
		tr = c[x].getElementsByTagName("tr")[2];
		tr.parentNode.insertBefore(h,tr);
		c[x].getElementsByTagName("td")[3].innerHTML = "Members Online Today";
		h = c[x].getElementsByTagName("tr")[1].cloneNode(true);
		tr.parentNode.insertBefore(h,tr);
		c[x].getElementsByTagName("td")[4].innerHTML = "<img src='"+img+"' alt='' />";
		c[x].getElementsByTagName("td")[5].innerHTML = open_b+"<?=$count;?>"+close_b+"<? if($count<=1){echo " Member Online today.";}else{echo " Members Online today.";}echo "<br />";?>"+breakline+"<?$re = mysql_query("SELECT * FROM `users` WHERE `url` = '$url'") or die(mysql_error());$x = 1;while($ro = mysql_fetch_array($re)){echo "<a href='".$url2."/index.php?showuser=".$ro['uid']."'>".$ro['user']."</a>";if($count!=$x){echo ", ";}$x=++$x;} ?>";
	}
}
		<?
		}
	}
?>
