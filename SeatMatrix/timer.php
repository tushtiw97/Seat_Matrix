<?php
	$id = $_GET['id'];
	sleep(60);
	$conn = new mysqli("localhost","root","password","database");
	
	if(!$conn){
		echo "Cannot contact DB";
	}
	else {
		$result = $conn->query("select status from seats where booking_id=$id");
				
		$flag1 = 0;
				
		while($row = $result->fetch_assoc()){
			$flag1 = 0;
			if($row['status'] == "booked"){
				$flag1 = 1;
				break;
			}
		}
				
		if($flag1 == 1){
			$result = $conn->query("delete from seats where booking_id=$id");
			echo "Payment not made. Seats released";
		}
		else {
			echo "Seats paid for";
		}
		$conn->close();
	}
?>
