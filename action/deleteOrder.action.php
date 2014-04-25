<?php
	require("./public.action.php");

	if(!isInOrderTime(time())) {
		die(json_encode(array('status' => 0, 'msg' => '已截止订餐或订餐未开始')));
	}


	$orderId = safePost('orderId');
	$userId = $_SESSION['id'];

	$queryStr = "SELECT time, isPaid FROM orders WHERE userId = '$userId' AND orderId = '$orderId' ";
	$queryResult = mysql_query($queryStr);
	if($time = mysql_fetch_row($queryResult)) {
		$time = $time[0];
		$isPaid = $time[1];
		if($isPaid == '1') {
			isSuccess(0);
		}
		if(time() + $timeError - $time > $editableTime) {
			isSuccess(0);
		} else {
			$deleteStr = "DELETE FROM orders WHERE userId = '$userId' AND orderId = '$orderId' ";
			$result = mysql_query($deleteStr);
			isSuccess($result);
		}
	} else {
		isSuccess(0);
	}

	function isSuccess($result) {
		if(!$result) {
			$data = array('status' => 0, 'msg' => 'operate failed');
			die(json_encode($data));
		} else {
			$data = array('status' => 1, 'msg' => 'operate succeed');
			die(json_encode($data));
		}
	}


?>