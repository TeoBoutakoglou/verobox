function login_toast(elementId){
    var text = document.getElementsByClassName("login-toast-message")[0].textContent;
    
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

function register_error_toast(elementId){
    var text = document.getElementsByClassName("register-error-toast-message")[0].textContent;
    
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