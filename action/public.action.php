<?php
	$con = mysql_connect("localhost", "root", "root");
	if(!$con) {
		die("can not connect to the database");
	}

	mysql_select_db("orderLunch");
	session_name("orderLunch");
	session_start();
	$editableTime = 60 * 5;
	$timeError = 3600 * 8;

	$orderTime = array();
	array_push($orderTime, array('beginTime' => '00:00', 'endTime' => '24:00'));
	//array_push($orderTime, array('beginTime' => '15:30', 'endTime' => '16:30'));
	
	function safePost($key) {
		if($key != '' && isset($_POST[$key]) && $_POST[$key] != '') {
			return htmlspecialchars(mysql_real_escape_string($_POST[$key]),ENT_NOQUOTES);
		}
		return false;
	}

	function safeGet($key) {
		if($key != '' && isset($_GET[$key]) && $_GET[$key] != '' && !isset($_GET[$key][10])) {
			return mysql_real_escape_string($_GET[$key]);
		}
		return false;
	}

	function getNameById($id) {
		$queryStr = "SELECT name FROM user WHERE id = '$id' LIMIT 1 ";
		$queryResult = mysql_query($queryStr);
		$name = mysql_fetch_row($queryResult);
		return $name[0];
	}

	function getMsgByLunchType($type) {
		$queryStr = "SELECT name, price FROM menu WHERE type = '$type' LIMIT 1 ";
		$queryResult = mysql_query($queryStr);
		$name = mysql_fetch_array($queryResult);
		return $name;
	}

	function isInOrderTime($time) {
		global $orderTime;
		$time = date("H:i", $time + $timeError);
		foreach ($orderTime as $oTime) {
			if($time >= $oTime['beginTime'] && $time <= $oTime['endTime']) {
				return true;
			}
		}
		return false;
	}



?>
