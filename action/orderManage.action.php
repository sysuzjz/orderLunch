<?php
	require("./public.action.php");
	$isDeleteBtn = safePost('isDeleteBtn');
	$orderId = safePost('orderId');
	if($isDeleteBtn) {
		if(!isset($_SESSION['adminId']))
			isSuccess(0);
		deleteOrder($orderId);
		
	} else {
		$paid = safePost('paid');
		$repaid = safePost('repaid');
		$helper = safePost('helper');
		$price = safePost('price');
		$uid = safePost('uid');
		$debt = $price + $repaid - $paid;
		if($helper != $uid)
			addToDebt($uid, $helper, $debt);
		else {

		}
	}
	function addToDebt($user, $debter, $debt) {
		$originDebt = getOriginDebt($user, $debter);
		$flag = exitRecord($user, $debter);
		if($flag == -1) {
			swap($debter, $user, -$originDebt);
		}
		if($originDebt === false) {
			insert($user, $debter, $debt);
			$originDebt = 0;
		}

		$newDebt = $originDebt + $debt;

		if(exitRecord($user, $debter) == -1) {
			update($debter, $user, $newDebt);
		} else {
			update($user, $debter, $newDebt);
		}

		if($newDebt < 0) {
			swap($user, $debter, $newDebt);
		}
	}

	function getOriginDebt($user, $debter) {
		$flag = exitRecord($user, $debter);
		if($flag == 0) {
			return false;
		} else {
			if($flag == 1) {
				$queryStr = "SELECT debt FROM debt WHERE userId = '$user' AND debter = '$debter' ";
			} else {
				$queryStr = "SELECT debt FROM debt WHERE userId = '$debter' AND debter = '$user'";
			}
			$queryResult = mysql_query($queryStr);
			$debt = mysql_fetch_row($queryResult);
			$debt = $debt[0];
			return $debt * $flag;
		}
	}

	function exitRecord($user, $debter) {
		if(query($user, $debter)) {
			return 1;
		} elseif(query($debter, $user)) {
			return -1;
		} else {
			return 0;
		}
	}

	function query($user, $debter) {
		$queryStr = "SELECT * FROM debt WHERE userId = '$user' AND debter = '$debter' ";
		$queryResult = mysql_query($queryStr);
		return mysql_fetch_row($queryResult);
	}

	function swap($user, $debter, $debt) {
		update($debter, $user, -$debt, $user, $debter);
	}

	function insert($user, $debter, $debt) {
		$insertStr = "INSERT INTO debt (userId, debter, debt)
					value('$user', '$debter', $debt) ";
		$result = mysql_query($insertStr);
		isSuccess($result);
	}

	function update($user, $debter, $debt, $originUser = '', $originDebter = '') {
		if(!$originUser) {
			$originUser = $user;
		}
		if(!$originDebter)
			$originDebter = $debter;
		$flag = exitRecord($user, $debter);
		$updateStr = "UPDATE debt SET userId = '$user', debter = '$debter', debt = '$debt' WHERE userId = '$originUser' AND debter = '$originDebter' ";
		$result = mysql_query($updateStr);
		isSuccess($result);
	}

	function deleteOrder($orderId) {
		$deleteStr = "DELETE FROM orders WHERE orderId = '$orderId' LIMIT 1 ";
		isSuccess(mysql_query($deleteStr));
	}

	function isSuccess($result) {
		if(!$result) {
			$data = array('status' => 0, 'msg' => 'operate failed');
			die(json_encode($data));
		}
	}

	if($paid == 0) {
		$updateStr = "UPDATE orders SET helper = '$helper', returnMoney = '$repaid' WHERE orderId = '$orderId' ";
	} else {
		$updateStr = "UPDATE orders SET helper = '$helper', isPaid = '1', actuallyPaid = '$paid', returnMoney = '$repaid' WHERE orderId = '$orderId' ";
	}
	$result = mysql_query($updateStr);
	isSuccess($result);

	$data = array('status' => 1, 'msg' => 'operate succeed');
	die(json_encode($data));
?>