<?php
	session_name("orderLunch");
	session_start();
	if(isset($_SESSION['adminId']) && !isset($_SESSION['id'])) {
		$location = "/orderLunch/admin.php";
	} else {
		$location = "/orderLunch/index.php";
	}
	session_unset();
	session_destroy();
	header("location:".$location);

?>