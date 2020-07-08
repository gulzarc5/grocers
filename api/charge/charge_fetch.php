<?php
	include_once '../../php/database/connection.php';
 	header("content-type: application/json");


 		$min_purchase_amount = 0;
		$min_purchase_charge = 0;
		$express_charge = 0;

		$min_p_amt_sql = 'SELECT * FROM `charges` WHERE `id` = "1"';
		if ($res_min_p_amt = $connection->query($min_p_amt_sql)) {
			$row__min_p_amt = $res_min_p_amt->fetch_assoc();
			$min_purchase_amount = $row__min_p_amt['amount'];
		}
	
		$min_p_charge_sql = 'SELECT * FROM `charges` WHERE `id` = "2"';
		if ($res_min_p_charge = $connection->query($min_p_charge_sql)) {
			$row__min_p_charge = $res_min_p_charge->fetch_assoc();
			$min_purchase_charge = $row__min_p_charge['amount'];
		}


		$express_p_charge_sql = 'SELECT * FROM `charges` WHERE `id` = "3"';
		if ($res_express_p_charge = $connection->query($express_p_charge_sql)) {
			$row__express_p_charge = $res_express_p_charge->fetch_assoc();
			$express_charge = $row__express_p_charge['amount'];
		}

		$response =[
			"status" => true,
			'message' => 'Please Check Required Fields',
			'min_purchase_amount'=> $min_purchase_amount,
			'min_purchase_charge'=> $min_purchase_charge,
			'express_charge'=> $express_charge,
		];
		http_response_code(200);
		echo json_encode($response);
		die();

?>