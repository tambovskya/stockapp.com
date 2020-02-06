<?php if (isset($_POST["SaveChanges"])) {

	require "dbh.inc.php";

	$NewProductName = $_POST["ProductName"];
	$NewProductQuantity = $_POST["ProductQuantity"];
	
	$ProductID = $_GET["ProductID"];

	echo $NewProductName;
	echo $NewProductQuantity;

	$sql = 'UPDATE Products SET ProductName="'.$NewProductName.'", ProductQuantity="'.$NewProductQuantity.'" WHERE ProductID="'.$ProductID.'";';

} ?>