var firstTimer = 10000;
var secondTimer = 10000;
var loggOut = "../php/logout.php"; 
var myTimer;
var modal = document.getElementById('modal');



//Actions that make the site know that you are active
/*window.onkeypress = ResetTimer;
window.onmousedown = ResetTimer;
window.onmousemove = ResetTimer;
window.onclick = ResetTimer;
window.onscroll = ResetTimer;
*/
//first timer
function StartTimer() {
	myTimer = window.setTimeout(WarningTimer, firstTimer);
}
//when a set time has passed you get a warrning message before you get logged out
function WarningTimer() {
	modal.style.display = "block";
	clearTimeout(myTimer);
	myTimer = window.setTimeout(LoggOut, secondTimer);

}

function ResetTimer() {
	modal.style.display = "none";
	clearTimeout(myTimer);
	StartTimer();
}

function LoggOut() {
	window.location = loggOut;
}

//}
