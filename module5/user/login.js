//check user log in or not

$( document ).ready(function() {
	var login=false;
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "select.php", true);
	xmlHttp.addEventListener("load", function(event){
		var jsonData= JSON.parse(event.target.responseText);
		if(jsonData.login){
			login=true;
			// $('#logout').show();
		}
		else{
			login=false;
			// $('#login').show();
		}
		checkLogin(login);
	}, false);
	xmlHttp.send(null);
});