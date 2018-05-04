//add event function 
function clickDay(e){
    // e.target is our targetted element.
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "select.php", true);
	xmlHttp.addEventListener("load", function(event){
		var jsonData= JSON.parse(event.target.responseText);
		if(jsonData.login){
			$("#modal-div").show();
		}
		else{
			$("#cancel_event_btn").trigger('click');
			$("#close").trigger('click');
			alert("You have not Log In");
		}
	}, false);
	xmlHttp.send(null);

    console.log(e.target.nodeName);
    if(e.target && e.target.nodeName == "LI") {
    	var dayObj = $("#"+e.target.id).data("dayObj");
    	alert(dayObj.date);
    	$("#event_date").val(dayObj.info);
	}
}

function EventAjax(event){
	var title= document.getElementById("event_title").value;
	var date= document.getElementById("event_date").value;
	var time= document.getElementById("event_time").value;
	var close= document.getElementById("cancel_event_btn");
	var t= document.getElementById("token").value;
	console.log("other file:"+ t);
		// Make a URL-encoded string for passing POST data:
	// var dataString = "title=" + encodeURIComponent(title) + "&date=" + encodeURIComponent(date) + "&time=" + encodeURIComponent(time);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "create_event.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			document.getElementById("event_title").value= "";
			document.getElementById("event_time").value= "";
			close.click();
			alert('success');
		}else{
			alert('fail');
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send("date=" + date + "&time=" + time + "&title=" + title +"&category=" +"empty"+ "&token=" +t );
}

document.getElementById("add_event_btn").addEventListener("click", EventAjax, false); // Bind the AJAX call to button click