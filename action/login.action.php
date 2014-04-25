<?php
	require("./public.action.php");

	$sid = safePost("sid");
	$password = safePost("password");
	$password = md5($password);
	$remember = safePost("remember");
	$selectStr = "SELECT * FROM user WHERE id = '$sid' AND password = '$password' LIMIT 1 ";
	$selectResult = mysql_query($selectStr);
	$userMsg = mysql_fetch_array($selectResult);
	if($userMsg) {
		$_SESSION['id'] = $userMsg['id'];
		$_SESSION['name'] = $userMsg['name'];
		$_SESSION['email'] = $userMsg['email'];

		if($remember == 'true') {
			setcookie(session_name(), session_id(), time() + 3600 * 24 * 7, '/');

		}

		$data = array('status' => 1, 'msg' => 'success');
	} else {
		$data = array('status' => 0, 'msg' => 'please check out your massages');
	}

	echo json_encode($data);

?>