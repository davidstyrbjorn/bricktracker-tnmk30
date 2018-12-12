function dropdownFunction() {
    document.getElementById("temp").classList.toggle("show");
}

window.onclick = function(e){
    if(!e.target.matches('temp')){
        if(document.getElementById("temp").classList.contains('show')){
            document.getElementById("temp").classList.remove('show');
        }
    }
}

//temp är div id för droppdown diven
//skappa en css för .show som gör display:block
