<?php
	require("./public.action.php");

	$id = $_SESSION['id'];
	$name = safePost("name");
	$email = safePost("email");
	$password = safePost("password");

	if(!$password) {
		$updateStr = "UPDATE user SET name = '$name', email = '$email' WHERE id = '$id' ";
		$result = mysql_query($updateStr);
	} else {
		$updateStr = "UPDATE user SET name = '$name', email = '$email', password = '$password' WHERE id = '$id' ";
		$result = mysql_query($updateStr);
	}
	if($result) {
		$_SESSION['name'] = $name;
		$_SESSION['email'] = $email;
		$data = array('status' => 1, 'msg' => 'operate success');
	} else {
		$data = array('status' => 0, 'msg' => 'operate failed');
	}
	$data = json_encode($data);
	die($data);
?>