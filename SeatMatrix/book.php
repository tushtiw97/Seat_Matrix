<?php
	$a = $_GET['seats'];
	$movie = $_GET['movie'];
	$date = $_GET['date'];
	$time = $_GET['time'];
	
	$conn = new mysqli("localhost","root","password","database");
	
	if(!$conn){
		echo "Cannot establish connection to the database";
	}
	else {
		$result = $conn->query("select seat from seats where movie='".$movie."' and ondate='".$date."' and attime='".$time."'");
		
		if(!$result){
			echo "Cannot run 1st query";
		}
		else {
			$seats = json_decode($a,false);
			while($row = $result->fetch_assoc()){
				$flag = 0;
				foreach($seats as $i){
					if($i == $row['seat']){
						$flag = 1;
						break;
					}
				}
				if($flag == 1){
					break;
				}
			}
			
			if($flag == 1){
				echo "One or more seats you have selected have just been booked by someone else. Please try selecting some other seats";
			}
			else {
				$result1 = $conn->query("select max(booking_id) from seats");
				$row = $result1->fetch_assoc();
				$id = (int)$row['max(booking_id)'] + 1;
				
				foreach($seats as $i){
					$result = $conn->query("insert into seats values (".$id.",'".$i."','".$movie."','".$date."','".$time."','booked')");
				}
				
				echo "Your seats have been temporarily booked. Please proceed towards the payment gateway$id";
			}
		}
		$conn->close();
	}
?>
