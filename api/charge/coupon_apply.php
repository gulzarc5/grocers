<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id']) && !empty($_POST['coupon_code'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$coupon_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['coupon_code']));


 		if (!empty($pin)) {
 			$sql = "INSERT INTO `shipping_address`(`id`, `user_id`, `state`, `city`, `location`, `mobile`, `email`, `pin`) VALUES (null,'$user_id','$state','$city','$address','$mobile','$email','$pin')";
 		}else{
 			$sql = "INSERT INTO `shipping_address`(`id`, `user_id`, `state`, `city`, `location`, `mobile`, `email`, `pin`) VALUES (null,'$user_id','$state','$city','$address','$mobile','$email',null)";
 		}
 		
 		if ($res = $connection->query($sql)) {
 			$response =[
				"status" => true,
				'message' => 'Shipping Address Added Successfully',
			];
			http_response_code(200);
			echo json_encode($response);
			die();
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong Please Try Again',
			];
			http_response_code(200);
			echo json_encode($response);
			die();
 		}
 	}else{
 		$response =[
			"status" => false,
			'message' => 'Please Check Required Fields',
		];
		http_response_code(200);
		echo json_encode($response);
		die();
 	}




?>