// ajax.js
var token;
function checkLogin(login){
	if(login){
		$('#logout').show();
	}
	else
	{
		$('#login').show();
	}
}
//register
document.getElementById("register_btn").addEventListener("click", function(){
	window.location.assign('register.html');
});
//login 
function loginAjax(event){
	var username = document.getElementById("Lusername").value; // Get the username from the form
	var password = document.getElementById("Lpassword").value; // Get the password from the form
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "select.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		document.getElementById("Lusername").value= ""; // clear the username
		document.getElementById("Lpassword").value= ""; // clear the password
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			token= jsonData.token;
			console.log(token);
			alert("You've been Logged In!");
			$('#login').hide();
			$('#logout').show();
		}else{
			alert("You were not logged in.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click

//logout function 
 
function logoutAjax(event){
	var logout = document.getElementById("logout_btn").value; // Get the logout from the form
	var dataString = "logout=" + encodeURIComponent(logout); 

	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "select.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Logged Out!");
			$('#login').show();
			$('#logout').hide();
		}else{
			alert("You have not logged Out.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

document.getElementById("logout_btn").addEventListener("click", logoutAjax, false); // Bind the AJAX call to button click




