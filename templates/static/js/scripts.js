document.addEventListener("DOMContentLoaded", hidePopUp);

function setInfo(id){
    document.getElementById('delIdInput').value = id;
    showPopUp();
}

function showPopUp(){
    let popUpWindow = document.getElementById('popUp');
    popUpWindow.style.display = "";
}

function hidePopUp(){
    let popUpWindow = document.getElementById('popUp');
    popUpWindow.style.display = "none";
}