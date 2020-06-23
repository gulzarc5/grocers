<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
	header("content-type: application/json");
	
	$sliders = [];
	$new_arrivals = [];
	$popular_products = [];
	$trending_products = [];

	$sql = "SELECT * FROM `slider` WHERE `status`='1'";
	if ($res = $connection->query($sql)) {
		while($slider = $res->fetch_assoc()){		
			$sliders[] = [
			'id' => $slider['id'],
			'image' => $slider['image'],
			'title' => $slider['title'],
			];
		}
	}

	$sql = "SELECT * FROM `product` ORDER BY `id` DESC LIMIT 10";
	if ($res = $connection->query($sql)) {
		while($new_arrival = $res->fetch_assoc()){		
			$new_arrivals[] = [
			'id' => $new_arrival['id'],
			'name' => $new_arrival['name'],
			'mrp' => $new_arrival['mrp'],
			'price' => $new_arrival['price'],
			'cash_back' => $new_arrival['cash_back'],
			'promotional_bonus' => $new_arrival['promotional_bonus'],
			'image' => $new_arrival['image'],
			];
		}
	}

	$sql = "SELECT * FROM `product` WHERE `is_tranding`='2' ORDER BY `id` DESC";
	if ($res = $connection->query($sql)) {
		while($trending_product = $res->fetch_assoc()){		
			$trending_products[] = [
			'id' => $trending_product['id'],
			'name' => $trending_product['name'],
			'mrp' => $trending_product['mrp'],
			'price' => $trending_product['price'],
			'cash_back' => $trending_product['cash_back'],
			'promotional_bonus' => $trending_product['promotional_bonus'],
			'image' => $trending_product['image'],
			];
		}
	}

	$sql = "SELECT * FROM `product` WHERE `is_popular`='2' ORDER BY `id` DESC";
	if ($res = $connection->query($sql)) {
		while($popular_product = $res->fetch_assoc()){		
			$popular_products[] = [
			'id' => $popular_product['id'],
			'name' => $popular_product['name'],
			'mrp' => $popular_product['mrp'],
			'price' => $popular_product['price'],
			'cash_back' => $popular_product['cash_back'],
			'promotional_bonus' => $popular_product['promotional_bonus'],
			'image' => $popular_product['image'],
			];
		}
	}

	$data = [
		'sliders' => $sliders,
		'new_arrivals' => $new_arrivals,
		'polular_products' => $popular_products,
		'trending_products' => $trending_products,
	];
	$response =[
		"status" => true,
		'message' => 'App Load Data',
		'data' =>$data,
	];
	http_response_code(200);
	echo json_encode($response);
	
?>