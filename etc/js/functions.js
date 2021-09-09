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

function get_item_extension(itemName)
{
    return  itemName.split('.').pop();
}

function is_allowed_item_extension(itemExtension)
{
    const allowedExtensions = ["pdf", "doc", "log", "txt", "iso", //Files
                               "jpg", "png", //Images
                               "mkv", "mp4" //Videos
                            ];
    return allowedExtensions.includes(itemExtension.toLowerCase());
}

function is_file(itemExtension)
{
    const fileExtensions = ["pdf", "doc", "log", "txt", "iso"];
    return fileExtensions.includes(itemExtension.toLowerCase());
}

function is_image(itemExtension)
{
    const imageExtensions = ["jpg", "png"];
    return imageExtensions.includes(itemExtension.toLowerCase());
}

function is_video(itemExtension)
{
    const videoExtensions = ["mkv", "mp4"];
    return videoExtensions.includes(itemExtension.toLowerCase());
}

function get_item_type(itemExtension)
{
    if (is_file(itemExtension)) return 'file';
    else if (is_image (itemExtension)) return 'image';
    else if (is_video(itemExtension)) return 'video';
}

function is_allowed_item_size(itemSize)
{
    if(itemSize <= 104857600) //in bytes (exaclty 100MB)
        return true;
    else 
        return false; 
}

function hide_upload_dialog(className)
{
    var element = document.getElementsByClassName(className)[0];
    element.style.display = "none";
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
                if(!is_allowed_item_size(item.size))
                {
                    alert("Your item is to big to upload");
                }
                else
                {
                    let itemName = item.name;
                    itemExtension = get_item_extension(itemName);
                    
                    if(!is_allowed_item_extension(itemExtension))
                    {
                        alert("You cannot upload this type of item");
                    }
                    else
                    {
                        if(itemName.length >=30) //split the name if its bigger than 30 chars
                        {
                            itemName = itemName.substring(0, 22) + "..." + itemName.substring(itemName.length - 4);
                        }
                        upload_item(itemName, uploadForm, progressArea, uploadedArea);  
                    }
                }
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
        let itemSizeInBytes = total; 
        let itemSize;

        if(itemSizeInBytes < Math.pow(1024, 1))
        {
            itemSize = (itemSizeInBytes / Math.pow(1024, 0)) + " B";
        }
        else if(itemSizeInBytes < Math.pow(1024, 2))
        {
            itemSize = (itemSizeInBytes / Math.pow(1024, 1)).toFixed(2) + " KB";
        }
        else
        {
            itemSize = (loaded / Math.pow(1024, 2)).toFixed(2) + " MB";
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

