<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
	 header("content-type: application/json");
	 date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['user_id']) && !empty($_POST['shipping_address_id']) && !empty($_POST['delivery_status'])) {

 		//All Form Data Stored In Variable
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$shipping_address_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['shipping_address_id']));
		
 		$date = date('Y-m-d');
	 	$time = date('H:i:s');

	 	$delivery_status = $_POST['delivery_status'];
	 	// 1 = morning Shift, 2 = Evening Shift, 3 = Express

	 	// Fetch Cart Items For Order
 		$sql_cart = "SELECT * FROM `cart` WHERE `u_id`='$user_id'";
 		if ($res_cart = $connection->query($sql_cart)) {

 			//If cart Is Not Empty Then Place Order
 			if ($res_cart->num_rows > 0) {

 				//Create Order Id For Placing Order
				$order_create_sql = "INSERT INTO `orders`(`user_id`,`shipping_address_id`,`date`,`time`, `status`,`delivery_time`) VALUES ('$user_id','$shipping_address_id','$date','$time','1','$delivery_status')";
 				// Declare A Variable For Counting Amount OF Order
 				$total_amount = 0;

 				if ($order_res_sql = $connection->query($order_create_sql) ) {
 					//Order Id Stored In A Variable For Placing Order Agains Items
 					$order_id = $connection->insert_id;

 					//Fetch Cart Items Row By Row 
 					while ($row_cart = $res_cart->fetch_assoc()) {
 						//Fetch Product Price For Placing An Order
 						$sql_price = "SELECT `price`,`stock`,`sub_cat_id` FROM `product` WHERE `id`='$row_cart[p_id]'";
 						if ($res_price = $connection->query($sql_price)) {
 							//Price From Product Table
							$row_price = $res_price->fetch_assoc();
							$price_product = $row_price['price'];
							$single_price = floatval($price_product) * $row_cart['quantity'];

							$total_amount = floatval($total_amount) + ($single_price);
							 
							$order_details_sql = "INSERT INTO `order_details`(`user_id`, `order_id`, `p_id`, `price`, `quantity`, `date`, `time`) VALUES ('$user_id','$order_id','$row_cart[p_id]','$price_product','$row_cart[quantity]','$date','$time')";

							$stock = $row_price['stock'] - $row_cart['quantity'];

		 					if ($res_order_details = $connection->query($order_details_sql)) {
		 						$sql_stock_update = "UPDATE `product` SET `stock` = '$stock' WHERE `id` = '$row_cart[p_id]'";
		 						if ($res_stock_update = $connection->query($sql_stock_update)) {}
		 					}		 					
 						}

 					}
					/// After successfully insertion of order details Update Order with total amount
					$Payable_amount = $total_amount;
					$min_purchase_amount = 0;
					$min_purchase_charge = 0;
					$express_charge = 0;

					$min_p_amt_sql = 'SELECT * FROM `charges` WHERE `id` = "1"';
					if ($res_min_p_amt = $connection->query($min_p_amt_sql)) {
						$row__min_p_amt = $res_min_p_amt->fetch_assoc();
						$min_purchase_amount = $row__min_p_amt['amount'];
					}
					if ($Payable_amount < $min_purchase_amount) {
						$min_p_charge_sql = 'SELECT * FROM `charges` WHERE `id` = "2"';
						if ($res_min_p_charge = $connection->query($min_p_charge_sql)) {
							$row__min_p_charge = $res_min_p_charge->fetch_assoc();
							$min_purchase_charge = $row__min_p_charge['amount'];
							$Payable_amount +=$min_purchase_charge;
						}
					}

					if ($delivery_status == '3') {
						$express_p_charge_sql = 'SELECT * FROM `charges` WHERE `id` = "3"';
						if ($res_express_p_charge = $connection->query($express_p_charge_sql)) {
							$row__express_p_charge = $res_express_p_charge->fetch_assoc();
							$express_charge = $row__express_p_charge['amount'];
							$Payable_amount +=$express_charge;
						}
					}

					$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount', `min_p_amount_charge`='$min_purchase_charge',`express_charge`='$express_charge',`total`='$Payable_amount' WHERE `id`='$order_id'";

					if ($res_order_update = $connection->query($sql_update_order)) {
							// $sql_cart_delete = "DELETE FROM `cart` WHERE `u_id`='$user_id'";
							// $connection->query($sql_cart_delete);
					}

 					$response =[
					"status" => true,
					'message' => 'Order Placed successfully',
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 					
 				}else{
 					$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 				}


 			}else{
 				$response =[
				"status" => false,
				'message' => 'Sorry We Cant Place an Order Your Cart Is Empty',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			}
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong Please Check Cart',
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