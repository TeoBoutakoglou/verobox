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
    const uploadForm = document.querySelector(".home-content .upload-box form");
    let uploadItemSelector = "";
    let progressArea = "";
    let uploadedArea = "";
    uploadForm.addEventListener("click", ()=>{
        uploadItemSelector = uploadForm.querySelector(".upload-item-selector"),
        progressArea = document.querySelector(".home-content .upload-box .progress-area"),
        uploadedArea = document.querySelector(".home-content .upload-box .uploaded-area");
        uploadItemSelector.click();

        uploadItemSelector.onchange = ({target}) =>
        {
            let item = target.files[0]; //get the first item, if multiple items selected
            if(item) //if item is selected
            {
                let itemName = item.name;
                if(itemName.length >=30) //split the name if its bigger than 30 chars
                {
                    itemName = itemName.substring(0, 22) + "..." + itemName.substring(itemName.length - 4);
                }
                upload_item(itemName, uploadForm, progressArea, uploadedArea);
            }
        }

    });
}

function upload_item(itemName, uploadForm, progressArea, uploadedArea)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../upload_item.php");
    xhr.upload.addEventListener("progress", ({loaded, total}) => {
        let itemPercentageLoaded = Math.floor(loaded / total * 100);
        let itemTotal = Math.floor(total / 1000); //getting item in KB
        let itemSize;
        if(itemTotal < 1024)
        {
            itemSize = itemTotal + " KB";
        }
        else
        {
            itemSize = (loaded / (1024 * 1024)).toFixed(2) + " MB";
        }
        let progressHTML = `<li class="row">
                                <i class="fas fa-file-alt"></i>
                                <div class="content">
                                    <div class="details">
                                        <span class="name">${itemName} | Uploading...</span>
                                        <span class="percent">${itemPercentageLoaded}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" style="width:${itemPercentageLoaded}%"></div>
                                    </div>
                                </div>
                            </li>`;
        progressArea.innerHTML = progressHTML;

        if(loaded == total)
        {
            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row">
                                    <div class="content">
                                        <i class="fas fa-file-alt"></i>
                                        <div class="details">
                                            <span class="name">${itemName} | Uploaded</span>
                                            <span class="size">${itemSize}</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-check"></i>
                                </li>`;
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
        
    });
    let formData = new FormData(uploadForm);
    xhr.send(formData);
}

