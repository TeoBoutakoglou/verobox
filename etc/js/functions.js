function toast(elementId){
    var text = document.getElementsByClassName("message")[0].textContent;
    
    if(text === "")
        console.log("text is empty. Not run toast")
    else
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
