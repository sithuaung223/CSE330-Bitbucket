

var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");
 
// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function(req, resp){
	// This callback runs when a new connection is made to our HTTP server.
 
	fs.readFile("client.html", function(err, data){
		// This callback runs when the client.html file has been read from the filesystem.
		if(err) return resp.writeHead(500);
		resp.writeHead(200);
		resp.end(data);
	});
});
app.listen(3456);
 
var chatRoom= function chatRoom(admin,name,pass){
	this.admin= admin;
	this.name= name; 
	this.pass= pass;
	this.people=[];
	this.banlist = [];
}
// Do the Socket.IO magic:
var io = socketio.listen(app);
var public_room_list=[];
var users=[];
var private_room_list=[];


io.sockets.on("connection", function(socket){
	

	// This callback runs when a new Socket.IO connection is established.
	socket.on('login', function(data) {
		socket.username= data['user'];
		// This callback runs when the server receives a new message from the client.
		users.push(data['user']);
		console.log('user lists:'+ users);
	});

 	socket.on('creating_chat', function(data) {
		// This callback runs when the server receives a new message from the client.
		if(data["Rpass"]==''){
			var room = new chatRoom(data["Rname"]);
			public_room_list.push(room);
		}
		else{
			var room = new chatRoom(data['admin'], data["Rname"],data["Rpass"]);
			private_room_list.push(room);
		}
		// io.clients[sessionID].emit("creating_chat"+data["username"],{Rpass: data["Rpass"]}) // broadcast the message to other users		
		socket.emit("creating_chat",{Rname: data["Rname"]});
	});

socket.on('find', function(data) {
var found = false;
	for (var i = 0; i < users.length; i++) {
		if(users[i] == data['user']){
			//socket.emit("Found_user:",{Rname: public_room_list[i].name, Rpass: ''});
			found = true;
			console.log("user: "+data['user']+"found"); // log it to the Node.JS output
		}
	}
	console.log("found:"+found);
	socket.emit("user_found",{found: found});
});
	

	socket.on('joining_chat', function(data) {
		// This callback runs when the server receives a new message from the client.
		var Jname= data["Rname"];
		for(var i=0; i< public_room_list.length; i++){
			if(Jname == public_room_list[i].name){
				// io.clients[sessionID].send("joining_chat"+data["username"],{Rname: public_room_list[i].name, Rpass: ''});
				socket.emit("joining_chat",{Rname: public_room_list[i].name, Rpass: ''},public_room_list[i]);
			}
		}
		for(var i=0; i< private_room_list.length; i++){
			if(Jname == private_room_list[i].name){
				// io.clients[sessionID].send("joining_chat"+data["username"],{Rname: private_room_list[i].name, Rpass: private_room_list[i].pass});
				socket.emit("joining_chat",{Rname: private_room_list[i].name, Rpass: private_room_list[i].pass},private_room_list[i]);
			}
		}
	});

	socket.on('message_to_server', function(data,curr_room) {
		// This callback runs when the server receives a new message from the client.
 
		console.log("message: "+data["message"]); // log it to the Node.JS output
		console.log("current room: "+ curr_room);
		console.log("user: "+ data['user']);
		io.sockets.emit("message_to_client",{user: data['user'], message: data["message"], room: curr_room}) // broadcast the message to other users
	});

});