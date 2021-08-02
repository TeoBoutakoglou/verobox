function toast(elementId){
    var text = document.getElementsByClassName("toast-message")[0].textContent;
    
    if(!(text === ""))
    {
        var element = document.getElementById(elementId);
        element.classList.add("show");
        element.classList.add("alert");
        element.classList.remove("hide");
        
        setTimeout(function(){
            element.classList.remove("show");
            element.classList.add("hide");
        }, 3000);
    }
}
