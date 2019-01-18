var firstTimer = 10000;
var secondTimer = 60000;
var loggOut /*url av utloggningsida*/;
var myTimer;
var modal = document.getElementByID("modal");


function IdleTimer() {
    window.onmousemove = ResetTimer(); 
    window.onmousedown = ResetTimer(); 
    window.onclick = ResetTimer();     
    window.onscroll = ResetTimer();    
    window.onkeypress = ResetTimer();
    
    function StartTimer() {
        myTimer = window.setTimeout(WarningTimer(), firstTimer);
    }
    
    function WarningTimer() {
        modal.style.display = "block";
        clearTimeout(myTimer);
        myTimer = window.setTimeout(LoggOut(), secondTimer);
    }
    
    function ResetTimer() {
        modal.style.display = "none";
        clearTimeout(myTimer);
        StartTimer();
    }
    
    function LoggOut() {
        window.location = loggOut;
    }
}