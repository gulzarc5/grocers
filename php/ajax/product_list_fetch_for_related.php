<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
header("content-type: application/json");
$request = $_REQUEST;


$sql_count = "SELECT `product`.`id` as p_id,`product`.`name` as name,  `category`.`name` AS category FROM `product` INNER JOIN `category` ON `category`.`id`=`product`.`category_id`  WHERE (`product`.`is_delete`=1)";
//Searching 
if (!empty($request['search']['value'])) {
	$srch_key = $request['search']['value'];
	$sql_count = $sql_count." AND (`product`.`id` LIKE '%$srch_key%' OR `product`.`name` LIKE '%$srch_key%' OR `category`.`name`  LIKE '%$srch_key%')";

}

$sql = "SELECT `product`.*,`category`.`name` AS category FROM `product` INNER JOIN `category` ON `category`.`id`=`product`.`category_id`  WHERE (`product`.`is_delete`=1)";

if (!empty($request['search']['value'])) {
	$sql = $sql." AND (`product`.`id` LIKE '%$srch_key%' OR `product`.`name` LIKE '%$srch_key%' OR `category`.`name`  LIKE '%$srch_key%')";
}


if (isset($request['p_id']) && !empty($request['p_id'])) {
    $sql_related = "SELECT * FROM `related_product` WHERE `product_id`='$request[p_id]'";
    if ($res_related = $connection->query($sql_related)) {
        while ($row_related = $res_related->fetch_assoc()) {
            $sql_count = $sql_count." AND `product`.`id` != '$row_related[related_to_id]'";
            $sql = $sql." AND `product`.`id` != '$row_related[related_to_id]'";
        }
    }
    $sql_count = $sql_count." AND `product`.`id` != '$request[p_id]'";
    $sql = $sql." AND `product`.`id` != '$request[p_id]'";
    
}
//End Searching
if ($res_count = $connection->query($sql_count)) {
	$totalData = $res_count->num_rows;
	$totalFilater = $res_count->num_rows;
}

	// Ordering
	if($request['order'][0]['column'] != 0){
		$str_ord = $request['order'][0]['column'];
		$en_ord = $request['order'][0]['dir'];
		$sql = $sql."ORDER BY $str_ord $en_ord ";
	}else{
		$sql = $sql." ORDER BY `product`.`id` DESC ";
		// $sql = $sql."ORDER BY IF(`products`.`name` RLIKE '^[a-z]', 1, 2), `products`.`name`";
	}
	$sql = $sql." LIMIT $request[start],$request[length]";



if ($res = $connection->query($sql)) {
	$data = [];
	$count = 1;
	while ($row = $res->fetch_assoc()) {
		$action = '<button type="button" onclick="related_add('.$row['id'].')" class="btn btn-info">Add To Related</button>';
		$data[] = [
			$count,
			$row['id'],
			$row['name'],
			$row['category'],		
			$action,
		];
		$count++;
	}

	$jsonData = array(
		"draw" => intval(isset($_REQUEST["draw"]) ? $_REQUEST["draw"] : 0),
		"recordsTotal" => intval($totalData),
		"recordsFiltered" => intval($totalFilater),
		"data" => $data
	);

	echo json_encode($jsonData);
}
?>