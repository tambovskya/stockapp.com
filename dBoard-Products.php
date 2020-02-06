<?php include "header.php"; ?>

<div class="WelcomeScreen">
	<a id="backTop" href="dBoard-Products.php">
		<img src="img/package.png">
	</a>
	<h3>Let's get going</h3>
	<p>Tap the button below to add your first product.</p>
	<a href="dBoard-Products.php?dBoardAdd">Add Products</a>
	<a href="dBoard-Products.php?ViewProducts">View Products</a>
</div>

<?php if (isset($_GET["ViewProducts"])) { ?>

<table>
	<tr>
		<th>Product ID</th>
		<th>Product Name</th>
		<th>Product Quantity</th>
		<th></th>
		<th></th>
	</tr>

<?php

include "inc/dbh.inc.php";

$sql = "SELECT * FROM Products;";
$result = mysqli_query($link, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0) {
	while ($row = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php echo $row['ProductID']; ?></td>
			<td><?php echo $row['ProductName']; ?></td>
			<td><?php echo $row['ProductQuantity']; ?></td>
			<td><a href="dBoard-Products.php?Edit&ProductID=<?php echo $row['ProductID']; ?>">Edit</a>
			<td><a href="dBoard-Products.php?Delete&ProductID=<?php echo $row['ProductID']; ?>">Delete</a>
		</tr><?php
	}
}

?>

</table><?php } ?>

<?php if (isset($_GET["Delete"])) {

	echo "It's me! I'm here!";

	include "inc/dbh.inc.php";

	$ProductID = $_GET["ProductID"];

	$sql = "DELETE FROM Products WHERE ProductID=$ProductID";

	if (mysqli_query($link, $sql)) {
		echo "Success!";
		header("Location: dBoard-Products.php");
	}

} ?>

<?php if (isset($_GET["dBoardAdd"])) { ?>

	<form method="post" action="dBoard-Products.php?Create" class="dBoard-Form" id="dBoard-Add-Product">
		<div class="BoxInput Whole-Column">
			<label>Product Name</label>
			<input name="dBoardProductName" type="text" placeholder="Product Name">
		</div>
		<div class="BoxInput Whole-Column">
			<label>Product Quantity</label>
			<input name="dBoardProductQuantity" type="text" placeholder="Product Quantity">
		</div>
		<input type="submit" class="largeButton" value="Add Product">
	</form>

<?php } ?>

<?php if (isset($_GET["Create"])) {

	include "inc/dbh.inc.php";

	$dBoardProductName = $_POST["dBoardProductName"];
	$dBoardProductQuantity = $_POST["dBoardProductQuantity"];

	$sql = "INSERT INTO Products (ProductName, ProductQuantity) Values (?,?)";
	$stmt = mysqli_stmt_init($link);

	if(!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: dashboard.php?Error=SQL_Connection_Failed");
	}

	else {
		mysqli_stmt_bind_param($stmt, "ss", $dBoardProductName, $dBoardProductQuantity);
		mysqli_stmt_execute($stmt);
		header("Location: dBoard-Products.php");
		exit();
	}

} ?>

<?php if (isset($_GET["dBoardDelete"])) {
	require "inc/dbh.inc.php";

	$sql = "SELECT * FROM Products";
} ?>

<?php if (isset($_GET["Edit"])) { ?>

	<div class="SelectionBox">
		<h1>Product Editing</h1>

		<?php $ProductID = $_GET["ProductID"]; ?>

		<form action="dBoard-Products.php?Save&ProductID=<?php echo $ProductID; ?>" method="post">

			<?php include "inc/dbh.inc.php";

			$sql = "SELECT * FROM Products WHERE ProductID = $ProductID;";
			$result = mysqli_query($link, $sql);
			$resultCheck = mysqli_num_rows($result);

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>

					<div class="BoxInput">
						<label>Product Name</label>
						<input type="text" name="ProductName" value="<?php echo $row['ProductName'];?>">
					</div>

					<div class="BoxInput">
						<label>Product Quantity</label>
						<input type="text" name="ProductQuantity" value="<?php echo $row['ProductQuantity']; ?>">
					</div>

				<?php }
			} ?>

			<input type="submit" name="SaveChanges" class="largeButton" value="Submit Changes">

		</form>

	</div>

<?php } ?>

<?php if (isset($_GET["Save"])) {

	include "inc/dbh.inc.php";

	$NewProductName = mysqli_real_escape_string($link, $_POST["ProductName"]);
	$NewProductQuantity = mysqli_real_escape_string($link, $_POST["ProductQuantity"]);

	$ProductID = $_GET["ProductID"];

	$sql = "UPDATE Products SET ProductName='".$NewProductName."', ProductQuantity='".$NewProductQuantity."' WHERE ProductID='".$ProductID."';";

	if (mysqli_query($link, $sql)) {
		echo "Success!";
		header("Location: dBoard-Products.php");
	}

	else {
		echo "Fail!";
	}

} ?>

</body></html>

