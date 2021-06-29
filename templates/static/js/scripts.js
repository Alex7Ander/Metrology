document.addEventListener("DOMContentLoaded", hideAllPopUp);

function setInfo(id){
    document.getElementById('delIdInput').value = id;
    showPopUp('popUp');
}

function showPopUp(popUpId){
    let popUpWindow = document.getElementById(popUpId);
    popUpWindow.style.display = "";
}

function hidePopUp(popUpId){
    let popUpWindow = document.getElementById(popUpId);
    popUpWindow.style.display = "none";
}

function hideAllPopUp(){
	let popUpWindows = document.getElementsByClassName("popup");
	for(let win of popUpWindows){
		win.style.display = "none";
	}	
}

function loadFile(url, token, fileName){
    let urlObj = new URL(url);
    urlObj.searchParams.set("Authorization", "OAuth " + token);

	let xhr = new XMLHttpRequest();
	xhr.open('GET', urlObj, true);
    //xhr.setRequestHeader('X-CSRFToken', csrftoken);
    xhr.responseType = 'blob';   
    xhr.onload = function(e) {
        if (xhr.status != 200) { 
            alert(`Ошибка ${xhr.status}: ${xhr.statusText}`); 
        } 
        else { 
            var blob = xhr.response;
            var a = document.createElement('a');
            a.href = window.URL.createObjectURL(blob);
            a.download = fileName;
            a.dispatchEvent(new MouseEvent('click'));
        }
    };
    xhr.send();
}
