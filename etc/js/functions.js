function login_toast(elementId)
{
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

function register_error_toast(elementId)
{
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

function show_search_options_dropdown_list(className)
{
    var element = document.getElementsByClassName(className)[0];
    element.classList.toggle("show-list");
}

function show_upload_dialog(className)
{
    var element = document.getElementsByClassName(className)[0];
    element.style.display = "block";
}