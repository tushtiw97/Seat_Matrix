<?php
	$movie = $_GET['movie'];
	$date = $_GET['date'];
	$time = $_GET['time'];
	
	$seats = array("a1","a2","a3","a4","a5","a6","a7","a8","a9","a10","b1","b2","b3","b4","b5","b6","b7","b8","b9","b10","c1","c2","c3","c4","c5","c6","c7","c8","c9","c10","d1","d2","d3","d4","d5","d6","d7","d8","d9","d10");
	
	$status = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	
	$conn = new mysqli("localhost","root","password","database");
	
	if(!$conn){
		echo "Cannot establish connection to the database";
	}
	else {
		$result = $conn->query("select seat from seats where movie='".$movie."' and ondate='".$date."' and attime='".$time."'");
		
		if(!$result){
			echo "Can't retrieve the seats";
		}
		else {
			$a = array();
			while($row = $result->fetch_assoc()){
				$x = $row['seat'];
				array_push($a,$x);
			}
			//print_r($a);
			for($i=0;$i<40;$i++){
				foreach($a as $j){
					if($seats[$i] == $j){
						$status[$i] = 1;
					}
				}
			}
			for($i=0;$i<40;$i++){
				if($i%10 == 0){
					echo "<br>";
				}
				if($status[$i] == 1){
					echo "<button id='".$seats[$i]."' style='background-color : red' disabled>".$seats[$i]."</button>";
				}
				else {
					echo "<button id='".$seats[$i]."' onclick='selectSeat(".$seats[$i].")'>".$seats[$i]."</button>";
				}
			}
			echo "<br><button onclick='bookSeats()'>Continue</button>";
			echo "<button onclick='displaySeats()'>See selected seats</button>";
			echo "<button onclick='pay()'>Pay</button>";
		}
		$conn->close();
	}
?>
