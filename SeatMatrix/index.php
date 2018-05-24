<html>
	<head>
		<title>Mighty Bookings</title>
	</head>
	<body id="body">
		<?php
			$conn = new mysqli("localhost","root","password","database");
			
			if(!$conn){
				echo "Can't establish connection with the database";
				echo $conn->mysqli_error;
			}
			else {
				$result = $conn->query("select name from movies where available=true");
				
				if(!$result){
					echo "Cannot retrieve available movies";
				}
				else {
					echo "<select id='movie'>";
					echo "<option value='0'>Select Movie</option>";
					while($row = $result->fetch_assoc()){
						echo "<option value='".$row['name']."'>".$row['name']."</option>";
					}
					echo "</select>";
				}
				
				$conn->close();
			}
		?>
		<select id="date">
			<option value="0">Select Date</option>
			<option value="2018-05-20">2018-05-20</option>
			<option value="2018-06-20">2018-06-20</option>
		</select>
		<select id="time">
			<option value="0">Select Time</option>
			<option value="11:00:00">11:00 AM</option>
			<option value="14:30:00">2:30 PM</option>
			<option value="17:00:00">5:00 PM</option>
		</select>
		<button onclick="getSeats()">Continue</button>
		
		<script>
			var seats = [];
			var index = -1;
			
			var movie, date, time;
			
			function getSeats(){
				movie = document.getElementById("movie").value;
				date = document.getElementById("date").value;
				time = document.getElementById("time").value;
				
				if(movie == "0"){
					alert("Please select a movie");
				}
				else if(date == "0"){
					alert("Please select a date");
				}
				else if(time == "0"){
					alert("Please select a time");
				}
				else {
					alert("Movie : " + movie + "\nDate : " + date + "\nTime : " + time);
					var x = new XMLHttpRequest();
					x.onreadystatechange = function(){
						if(this.readyState == 4 && this.status == 200){
							document.getElementById("body").innerHTML = this.responseText;
						}
					};
					x.open("GET","script.php?movie=" + movie + "&date=" + date + "&time=" + time,true);
					x.send();
				}
			}
			
			function selectSeat(x){
				alert("Seat \"" + x.innerHTML + "\" Selected");
				document.getElementById(x.innerHTML).style.background = "green";
				seats[++index] = x.innerHTML;
			}
			
			function startTimer(id){
				alert("timer started");
				var x = new XMLHttpRequest();
				x.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						if(this.responseText == "Seats paid for"){
							
						}
						else
							alert(this.responseText);
					}
				};
				x.open("GET","timer.php?id=" + id,true);
				x.send();
			}
			
			function bookSeats(){
				var a = JSON.stringify(seats);
				var x = new XMLHttpRequest();
				x.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						alert("Movie : " + movie + "\nDate : " + date + "\nTime : " + time + "\nSeats : " + a);
						alert(this.responseText);
						if(this.responseText.substring(0,83) == "Your seats have been temporarily booked. Please proceed towards the payment gateway"){
							alert("starting timer");
							startTimer(this.responseText.substring(83, this.responseText.length));
						}
					}
				};
				x.open("GET","book.php?seats=" + a + "&movie=" + movie + "&date=" + date + "&time=" + time,true);
				x.send();
			}
			
			function displaySeats(){
				alert(seats);
				alert(JSON.stringify(seats));
			}
			
			function pay(){
				var a = JSON.stringify(seats);
				var x = new XMLHttpRequest();
				x.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						alert(this.responseText);
					}
				};
				x.open("GET","pay.php?seats=" + a + "&movie=" + movie + "&date=" + date + "&time=" + time,true);
				x.send();
			}
		</script>
	</body>
</html>
