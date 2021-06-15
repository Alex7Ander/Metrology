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