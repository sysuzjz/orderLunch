<?php
	require("./public.action.php");
	$sid = safePost("sid");
	$password = safePost("password");

	$selectStr = "SELECT * FROM admin WHERE id = '$sid' AND password = '$password' LIMIT 1 ";
	$selectResult = mysql_query($selectStr);
	$userMsg = mysql_fetch_array($selectResult);
	if($userMsg) {
		$_SESSION['adminId'] = $userMsg['id'];
		$data = array('status' => 1, 'msg' => 'success');
	} else {
		$data = array('status' => 0, 'msg' => 'please check out your massages');
	}

	echo json_encode($data);

?>