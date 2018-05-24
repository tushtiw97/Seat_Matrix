<?php
	$a = $_GET['seats'];
	$movie = $_GET['movie'];
	$date = $_GET['date'];
	$time = $_GET['time'];
	
	$seats = json_decode($a, false);
	
	$conn = new mysqli("localhost","root","password","database");
	
	if(!$conn){
		echo "Can't establish connection to database";
	}
	else {
		$flag = 0;
		foreach($seats as $i){
			$result = $conn->query("update seats set status='paid' where seat='".$i."' and movie='".$movie."' and ondate='".$date."' and attime='".$time."'");
			if(!$result){
				$flag = 1;
			}
		}
		if($flag == 0)
			echo "Done";
		else
			echo "Not done";
		$conn->close();
	}
?>
