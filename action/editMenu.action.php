<?php
	require("./public.action.php");

	$type = safePost('type');
	$name = safePost('name');
	$price = safePost('price');

	$queryStr = "SELECT type FROM menu WHERE type = '$type' LIMIT 1";
	$queryResult = mysql_query($queryStr);
	$queryNum = mysql_num_rows($queryResult);

	if($queryNum == 0) {
		$insertStr = "INSERT INTO menu (type, name, price)
					value('$type', '$name', '$price') ";
		$result = mysql_query($insertStr);
	} elseif($queryNum == 1) {
		$updateStr = "UPDATE menu SET name = '$name', price = '$price' WHERE type = '$type' ";
		$result = mysql_query($updateStr);
	} else {
		$result = 0;
	}
	if($result) {
		$data = array('status' => 1, 'msg' => 'success');
	} else {
		$data = array('status' => 0, 'msg' => 'operate failed');
	}
	$data = json_encode($data);
	die($data);
?>