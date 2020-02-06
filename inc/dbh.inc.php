<?php 

$link = mysqli_connect("localhost", "root", "root", "stockapp.com"); 

if (!$link) {
	die("Connect Error (" . mysqli_connecterrno() . ") "
		. mysqli_connect_error());
}

// echo "Success... " . mysqli_get_host_info($link) . "\n";

