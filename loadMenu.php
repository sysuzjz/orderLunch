<?php
	require("./action/public.action.php");
	header("Content-type: text/html; charset=utf-8"); 
	$file = fopen("D:\\wamp\\www\\orderLunch\\userMsg.txt", "r");
	$menus = array();
	while (!feof($file)) {
		$temp = str_replace("\n", "", fgets($file));
		$temp = str_replace("\r", "", $temp);
		if($temp == "")
			continue;
		array_push($menus, explode(" ", $temp));
	}
	var_dump($menus);
	$deleteStr = "DELETE FROM user WHERE 1";
	mysql_query($deleteStr);
	foreach ($menus as $menu) {
		$insertStr = "INSERT INTO user (id, password, name, email)
					value('$menu[0]', md5($menu[0]), '$menu[1]', '$menu[2]') ";
		mysql_query($insertStr);
	}
	// $queryStr = "SELECT * FROM menu";
	// $queryResult = mysql_query($queryStr);
	// $num = mysql_num_rows($queryResult);
	// $menuss = array();
	// for($i = 0; $i < $num; $i++) {
	// 	$temp = mysql_fetch_array($queryResult);
	// 	array_push($menuss, $temp);
	// }
	// var_dump($menuss);
	fclose($file);


?>