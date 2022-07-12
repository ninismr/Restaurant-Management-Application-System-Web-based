<?php 
	
	session_start();
	require "includes/functions.php";
	require "includes/db.php";
    if(!isset($_SESSION['user'])) {
        header("location: logout.php");
    }
	
	$result = "";
	$info = "";
	$items = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if(isset($_POST['order_id'])) {
			
			$order_id = htmlentities($_POST['order_id'], ENT_QUOTES, 'UTF-8');
			
			if($order_id != "") {
				
				$arr_id = explode("_", $order_id);
				
				$id = $arr_id[0];
				
				$order = $db->query("SELECT * FROM basket WHERE id='".$id."' LIMIT 1"); 
				
				if($order->num_rows) {
					
					$row = $order->fetch_assoc();
					
					$info .= "<table class='table table-hover'>
						<thead>
							<th>Order_ID</th>
							<th>Customer Name</th>
							<th>Address</th>
							<th>Email</th>
							<th>Phone</th>
						</thead>
						<tbody>";
						
					$items .= "<table class='table table-hover'>
						<tbody>
						<tr>
							<th>Menu Name</th>
							<th>Qty</th>
							<td></td>
						</tr>";
						
					$info .= "<tr>
								<td>ORD_$id</td>
								<td>".$row['customer_name']."</td>
								<td>".$row['address']."</td>
								<td>".$row['email']."</td>
								<td>".$row['contact_number']."</td>
							</tr>";
							
					$get_data = $db->query("SELECT * FROM items WHERE order_id='".$id."'");
					
					
					while($data = $get_data->fetch_assoc()) {
						
						$items .= "<tr>
										<td>".$data['food']."</td>
										<td>".$data['qty']."</td>
										<td></td>
									</tr>";
						
					}
					
					$items .= "<tr>
									<th>Total Price</th>
									<th>IDR ".$row['total']."</th>
									<th></th>
								</tr>
								";
					
					$items .= "<tr>
									<th>Date and Time</th>
									<td>".$row['date_made']."</td>
									<th></th>
								</tr>
								";
					
					if($row['status'] == "paid off") {
						
						$items .= "<tr>
									<th>Status</th>
									<td>
										<select onChange=\"change_stat('".$id."')\" name='status' id='".$id."' class='form-control'>
											<option value='paid off$id' selected>paid off</option>
											<option value='not yet paid off_$id'>not yet paid off</option>
										</select>
									</td>
									<th></th>
								</tr>";
						
					}else{
						
						$items .= "<tr>
									<th>Status</th>
									<td>
										<select onChange=\"change_stat('".$id."')\" name='status' id='".$id."' class='form-control'>
											<option value='paid off_$id' >paid off</option>
											<option value='not yet paid off_$id' selected>not yet paid off</option>
										</select>
									</td>
									<th></th>
								</tr>";
						
					}
					
					$result = $info ."".$items;
					
					 echo $result;
					
				}
				
			}
			
		}elseif(isset($_POST['status'])) {
			
			$status = htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8');
			
			if($status != "") {
				
				$stat_arr = explode("_", $status);
				
				$stat_id = $stat_arr[1];
				$stat_name = $stat_arr[0];
				
				$update = $db->query("UPDATE basket SET status='".$stat_name."' WHERE id='".$stat_id."' LIMIT 1");
				
				if($update) {
					
					echo "Status updated to: $stat_name";
					
				}
				
			}
			
		}
		
	}
	
?>