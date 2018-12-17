var firstTimer = 600000;
var secondTimer = 60000;
var loggOut /*url av utloggningsida*/;
var myTimer;



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
        /*div show grej för varnings fönster bygger sen */
        clearTimeout(myTimer);
        myTimer = window.setTimeout(LoggOut(), secondTimer);
    }
    
    function ResetTimer() {
        clearTimeout(myTimer);
        StartTimer();
    }
    
    function LoggOut() {
        window.location = loggOut;
    }
}