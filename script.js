/**
	* Members online today v3.1
	* By www.swordbeta.com, https://github.com/michaeltricht/Zathyus-MOT
	* For Invisionfree and Zetaboard
*/

// Image marker
var img = "http://z3.ifrm.com/static/1/s_stats.png";
// Remove breaklines? 0 = no, 1 = yes.
var mot_breakline = 0;
// Online user number bold? 0 = no, 1 = yes.
var mot_boldnumber = 0;

// No edit required after this line
var type = 0; 
var a = document.getElementsByTagName("a");
for(x=0;x<a.length;x++) {
if (a[x].href=="http://www.invisionboard.com/") {
		type = 1;
		break;
	}
}
user = 0;
id = 0;
if (type==0) {
	var url = escape(document.getElementById("nav").getElementsByTagName("a")[0].href);
	if (!document.getElementById("top_info").innerHTML.match(/Guest/i)) {
		user = document.getElementById("top_info").getElementsByTagName("a")[0].innerHTML;
		id = document.getElementById("top_info").getElementsByTagName("a")[0].href.split("/profile/")[1];
		id = id.split("/")[0];
	}
} else {
	var url = escape(document.getElementById("navstrip").getElementsByTagName("a")[0].href);
	if (!document.getElementById("userlinks").innerHTML.match(/Guest/i)) {
		user = document.getElementById("userlinks").getElementsByTagName("a")[0].innerHTML;
		id = document.getElementById("userlinks").getElementsByTagName("a")[0].href.split("showuser=")[1];
	}
}
document.write("<scr"+"ipt src='http://www.swor"+"dbeta.com/zathyus/index.php?url="+url+"&type="+parseInt(type)+"&user="+user+"&id="+parseInt(id)+"'></scr"+"ipt>");
