/*
*	Members online today v3.1
*	By www.swordbeta.com, https://github.com/michaeltricht/Zathyus-MOT
*/
<?php
	// Include necessities.
	include('config.php');
	include('lib/MysqliDb.php');

	// Disable error reporting.
	if (!$config['debug']) {
		error_reporting(0);
	}

	// Setup MySQL connection.
	$mysqli = new Mysqlidb($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['database']);

	// UNIX time minus 24 hours.
	$limitTime = time() - (60 * 60 * 24);

	// Delete any users that have not been only the past 24 hours.
	$mysqli->where('date', $limitTime, '<');
	$mysqli->delete('users');

	// Are we not visiting the page directly?
	if (isset($_GET['url'])) {

		$url = $_GET['url'];
		// Strip overhead from the URL.
		if (preg_match("/\?s=/", $url)) {
			$url = explode("?s=", $url);
			$url = $url[0] . "?act=idx";
		}

		// Setup variables.
		$url = $mysqli->escape(strip_tags(trim(urldecode($url))));
		$user = $mysqli->escape(strip_tags(trim($_GET['user'])));

		// We're not a guest but a real user.
		if ($user == $_GET['user'] && isset($_GET['id']) && $user != "0" && $_GET['id'] != "0") {

			// Setup variables.
			$id = $mysqli->escape($_GET['id']);
			$type = $mysqli->escape($_GET['type']);

			// Are we in the database?
			$mysqli->where('user', $user);
			$mysqli->where('user_id', $id);
			$mysqli->where('url', $url);
			$currentUser = $mysqli->getOne('users');

			// Setup array.
			$data = array(
				'user_id' => $id,
				'user' => $user,
				'url' => $url,
				'date' => time()
			);

			// Is the current visitor in the database?
			if($mysqli->count == 0){
				$mysqli->insert('users', $data);
			} else {
				$mysqli->where('id', $currentUser['id']);
				$mysqli->update('users', $data);
			}
		}

		// Get the users for this particular board.
		$mysqli->where('url ', $url);
		$qu = $mysqli->get('users');
		$count = $mysqli->count;

		// Lets start with outputting some javascript.
		// TODO: Delegate this to a function.
		// TODO: Put javascript in separate files.
		// TODO: Not have the entire <td> row in a single line.
		?>
if (!img) {
var img = "http://209.85.62.23/style_images/1/user.gif";
}
if (typeof(mot_breakline) == 'undefined') {
	var breakline = "<br />";
} else if(mot_breakline == 0) {
	var breakline = "<br />";
} else {
	var breakline = "";
}
if (typeof(mot_boldnumber) == 'undefined') {
	var open_b = "";
	var close_b = "";
} else if (mot_boldnumber == 0) {
	var open_b = "";
	var close_b = "";
} else {
	var open_b = "<b>";
	var close_b = "</b>";
}
		<?
		// Zetaboard.
		if ($type == 0) {
			$urlZB = explode("/index/", $url);
			$urlZB = $urlZB[0];
		?>
//Created by Agent Moose, too lazy to figure out jquery
$("div#stats table.forums tr:contains('Board Statistics')").before("<tr><th colspan='2'>Members Online Today</th></tr><tr><td class='c_mark' id='motMarker'><img src='"+img+"'/></td><td>"+open_b+"<? echo $count; ?>"+close_b+"<?if($count<=1){echo " Member Online today.";}else{echo " Members Online today.";}echo "<br />";?>"+breakline+"<?$x = 1;foreach($qu as $row){echo "<a href='".$urlZB."/profile/".$row['user_id']."'>".$row['user']."</a>";if($count!=$x){echo ", ";}$x=++$x;} ?></td></tr>")
		<?
		} else {
			// Invisionfree.
			$urlIF = explode("/index.php", $url);
			$urlIF = $urlIF[0];
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
		c[x].getElementsByTagName("td")[5].innerHTML = open_b+"<?=$count;?>"+close_b+"<? if($count<=1){echo " Member Online today.";}else{echo " Members Online today.";}echo "<br />";?>"+breakline+"<?$x = 1;foreach($qu as $row){echo "<a href='".$urlIF."/index.php?showuser=".$row['user_id']."'>".$row['user']."</a>";if($count!=$x){echo ", ";}$x=++$x;} ?>";
	}
}
		<?
		}
	}
?>
