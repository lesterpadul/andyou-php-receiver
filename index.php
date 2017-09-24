<?php 
$room_name = $_GET['room_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.min.js"
	  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
	  crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="http://inn-wowza.nativecamp.net:3001/socket.io/socket.io.js"></script>
	<script>
		//MARK: initialize socket
		var socket = null;
		var user_config = {                
			user_type: "viewer",
			user_id: guidGenerator(),
			ip_address: "<?php echo $_SERVER["REMOTE_ADDR"]; ?>",
			device_type: "pc",
			chat_mode: "open",
			service_id: 1
		};
		var broadcast_hash = "<?php echo $room_name; ?>";

		//MARK: when the page is ready, connect to the socket server
		$(document).ready(function(){
			connectToSocket();
		});

		//MARK: connect to socket service
		function connectToSocket() {
			socket = io.connect("http://inn-wowza.nativecamp.net:3001/development");
			socket.off('connect').on('connect', function(){
				//MARK: room connection log
				console.warn("CONNECTED!");

				//MARK: handle socket events
				handleSocketEvents(socket);

				//MARK: emit room connection
				socket.emit("broadcast_connect_to_room", {    
			        broadcast_hash: broadcast_hash,
			        user_config: user_config
				});
			});
		}

		//MARK: handle socket connection events
		function handleSocketEvents(socket){
			//MARK: handle the events
			socket
			.off("broadcast_general_command").on("broadcast_general_command", function(data){
				console.warn(data);
			})

			//MARK: catch sent commands
			.off("broadcast_general_command_sent").on("broadcast_general_command_sent", function(data){
				console.warn("SENT COMMAND -> " + JSON.stringify(data));
			})

			//MARK: receive room connection event
			.off("broadcast_receive_conected_to_room").on("broadcast_receive_conected_to_room", function(data){
				console.warn("connected to room!");
			})

			//MARK: catch disconnection event
			.off("disconnect").on("disconnect", function(){
			})

			//MARK: catch error event
			.off("error").on("error", function(){
			});
		}

		//MARK: sample, create ID
		function guidGenerator() {
		    var S4 = function() {
		       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
		    };
		    return (S4()+S4()+"-"+S4());
		}
	</script>
</body>
</html>