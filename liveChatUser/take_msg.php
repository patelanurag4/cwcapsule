<?php
include('database_connection.php');
session_start();
$data = array(
 ':to_user_id'  => $_POST['to_user_id'],
 ':from_user_id'  => $_SESSION['id']
);
$from_user_id = $_SESSION['id'];
$to_user_id = $_POST['to_user_id'];
$questionId = $_POST['quid'];
///
// update notifications < - 
	$query2 = "UPDATE chat_message SET status = '0' WHERE from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."' AND status = '1'";
	$statement2 = $connect->prepare($query2);
	$statement2->execute();


// messages 

$query = "SELECT * FROM chat_message WHERE ((from_user_id = " . $data[":from_user_id"] . " AND to_user_id = " . $data[":to_user_id"] . ") OR (from_user_id = " . $data[":to_user_id"] . " AND to_user_id = " . $data[":from_user_id"] . ")) AND questionId = " . $questionId . " ORDER BY timestamp DESC";
$result = $connect->query($query);


$output = '<ul class="list-unstyled">';
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$user_name = '';
			if($row["from_user_id"] == $from_user_id) {
				$user_name = '<b class="text-success">You</b>';
			} else {
				$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
			}
			$output .= '
			<li style="border-bottom:1px dotted #ccc">
			<p>'.$user_name.' - '.$row["chat_message"].'
				<div align="right">
				- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
			</li>
			';
		}
	}
	$output .= '</ul>';
	echo $output;
?>
