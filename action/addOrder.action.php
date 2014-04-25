<?php
	require("./public.action.php");


	if(!isInOrderTime(time())) {
		die(json_encode(array('status' => 0, 'msg' => '不是订餐时间')));
	}

	// $orders = safePost('orders');
	$orders = $_POST['orders'];
	$isSelf = 1;
	if(safePost('id') && count($_POST['id']) > 0) {
		$isSelf = 0;
		$userIds = safePost('id');
	} else {
		$userId = $_SESSION['id'];
	}
	$time = time() + $timeError;

	$status = 1;
	for($i = 0; $i < count($orders); $i++) {
		$order = $orders[$i];
		if($isSelf == 0) {
			$userId = $userIds[$i];
		}
		$insertStr = "INSERT INTO orders (userId, lunchType, time)
						value('$userId', '$order', '$time') ";
		$insertResult = mysql_query($insertStr);
		if(!$insertResult) {
			$status = 0;
			break;
		}
	}
	if($status) {
		$data = array('status' => 1, 'msg' => 'operate success');
	} else {
		$data = array('status' => 0, 'msg' => 'operate failed');
	}
	$data = json_encode($data);
	die($data);

?>