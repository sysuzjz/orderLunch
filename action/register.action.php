<?php
	require("./public.action.php");
	// $sid = safePost("sid");
	// $email = safePost("email");
	// $name = safePost("name");
	// $password = safePost("password");
	// $password = md5($password);

	// $insertStr = "INSERT INTO user (id, password, name, email)
	// 			value('$sid', '$password', '$name', '$email') ";
	// $result = mysql_query($insertStr);
	$result = 0;
	if($result) {
		$data = array('status' => 1, 'msg' => 'success');
	} else {
		$data = array('status' => 0, 'msg' => 'please check out your massages');
	}

	die(json_encode($data));
?>