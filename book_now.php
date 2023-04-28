<?php 


include 'db_connect.php';
extract($_POST);

$data = ' schedule_id = '.$sid.' ';
$data .= ', name = "'.$name.'" ';
$data .= ', qty ="'.$qty.'" ';
if(!empty($bid)){
	$data .= ', status ="'.$status.'" ';
	$update = $conn->query("UPDATE booked set ".$data." where id =".$bid);
	if($update){
		$qry = $conn->query("SELECT availability FROM schedule_list where id = ".$schedule_id);
        print_r($qry)
		$remSeats = $qry - $qty;
	    $updateAvail = $conn->query("UPDATE schedule_list SET availability = ".$remSeats." WHERE id = ".$schedule_id);
		if($updateAvail){
			echo json_encode(array('status'=> 1));
		}
	}
	exit;
}
$i = 1;
$ref = '';
while($i == 1){
	$ref = date('Ymd').mt_rand(1,9999);
	$data .= ', ref_no = "'.$ref.'" ';
	$chk = $conn->query("SELECT * FROM booked where ref_no=".$ref)->num_rows;
	if($chk <=0)
		$i = 0;
}

// echo "INSERT INTO booked set ".$data;
	$insert = $conn->query("INSERT INTO booked set ".$data);
	if($insert){
		echo json_encode(array('status'=> 1,'ref'=>$ref));
	}
