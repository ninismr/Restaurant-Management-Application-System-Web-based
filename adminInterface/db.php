<?php 
	
	$db = new mysqli("localhost", "id18800028_group5", "@softwareEngineering2022", "id18800028_restaurantsystem");
	
	if($db->connect_errno) {
		
		echo "PLEASE BEAR WITH US AS WE ARE CURRENTLY WORKING ON OUR SITE!!!! PLEASE COME BACK LATER";
		
	}
	
?>