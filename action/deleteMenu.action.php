<?php
	require("./public.action.php");

	$type = safePost('type');

	$queryStr = "SELECT type FROM menu WHERE type = '$type' LIMIT 1 ";
	$queryResult = mysql_query($queryStr);
	$queryResultNum = mysql_num_rows($queryResult);

	if($queryResultNum == 1) {
		$deleteStr = "DELETE FROM menu WHERE type = '$type' LIMIT 1";
		$result = mysql_query($deleteStr);
	} else {
		$result = 0;
	}

	if($result) {
		$data = array('status' => 1, 'msg' => 'operate success' );
	} else {
		$data = array('status' => 0, 'msg' => 'operate failed');
	}
	$data = json_encode($data);
	die($data);

?>