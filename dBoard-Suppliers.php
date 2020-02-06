<?php include "header.php"; ?>

<div class="WelcomeScreen">
	<a id="backTop" href="dBoard-Suppliers.php">
		<img src="img/supplier.png">
	</a>
	<h3>Let's get going</h3>
	<p>Tap the button below to add your first supplier</p>
	<a href="dBoard-Suppliers.php?Form">Add Supplier</a>
	<a href="dBoard-Suppliers.php?ViewSuppliers">View Suppliers</a>
</div>

	<?php

		if (isset($_GET["ViewSuppliers"])) { ?>

		<table>

			<tr>
				<th>Supplier ID</th>
				<th>Supplier Name</th>
				<th>Building</th>
				<th>Address Line 1</th>
				<th>Address Line 2</th>
				<th>City</th>
				<th>State</th>
				<th>ZipCode</th>
				<th>Country</th>
				<th>Phone</th>
				<th>Email</th>
				<th></th>
				<th></th>
			</tr>

			<?php 

			include "inc/dbh.inc.php";

			$sql = "SELECT * FROM Suppliers;";
			$result = mysqli_query($link, $sql);
			$resultCheck = mysqli_num_rows($result);

			if ($resultCheck > 0) {
				while ($row = mysqli_fetch_assoc($result)) { ?>

					<tr>
						<td><?php echo $row["SupplierID"]; ?></td>
						<td><?php echo $row["SupplierName"]; ?></td>
						<td><?php echo $row["Building"]; ?></td>
						<td><?php echo $row["AddressLine1"]; ?></td>
						<td><?php echo $row["AddressLine2"]; ?></td>
						<td><?php echo $row["City"]; ?></td>
						<td><?php echo $row["State"]; ?></td>
						<td><?php echo $row["ZipCode"]; ?></td>
						<td><?php echo $row["Country"]; ?></td>
						<td><?php echo $row["Phone"]; ?></td>
						<td><?php echo $row["Email"]; ?></td>
						<td><a href="dBoard-Suppliers.php?Edit&SupplierID=<?php echo $row['SupplierID']; ?>">Edit</a></td>
						<td><a href="dBoard-Suppliers.php?Delete&SupplierID=<?php echo $row['SupplierID']; ?>">Delete</a></td>
					</tr>

				<?php }
			}

			else {

				echo "It does not work!";

			} ?>

			</table>

		<?php } ?>

<?php if(isset($_GET["Form"])) { ?>

	<form method="post" action="dBoard-Suppliers.php?AddSupplier" class="dBoard-Form" id="dBoard-Add-Supplier">

		<div class="BoxInput Whole-Column">
			<label>Supplier Name</label>
			<input type="text" name="SupplierName" placeholder="Name">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Building</label>
			<input type="text" name="Building" placeholder="Building">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Address Line 1</label>
			<input type="text" name="AddressLine1" placeholder="Address Line 1">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Address Line 2</label>
			<input type="text" name="AddressLine2" placeholder="Address Line 2">
		</div>

		<div class="BoxInput Third-Column">
			<label>City</label>
			<input type="text" name="City" placeholder="City">
		</div>

		<div class="BoxInput Third-Column">
			<label>State</label>
			<input type="text" name="State" placeholder="FL">
		</div>

		<div class="BoxInput Third-Column">
			<label>Zip Code</label>
			<input type="text" name="ZipCode" placeholder="Zip Code">
		</div>

		<div class="BoxInput Half-Column">
			<label>Country</label>
			<input type="text" name="ZipCode" placeholder="Zip Code">
		</div>

		<div class="BoxInput Half-Column">
			<label>Phone</label>
			<input type="text" name="ZipCode" placeholder="Zip Code">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Email</label>
			<input type="text" name="ZipCode" placeholder="Zip Code">
		</div>

		<input type="submit" class="largeButton" value="Add Supplier">

	</form>

<?php } ?>

<?php if (isset($_GET["AddSupplier"])) {

	include "inc/dbh.inc.php";

	$SupplierName = $_POST["SupplierName"];

	$sql = "INSERT INTO Suppliers (SupplierName) Values (?)";
	$stmt = mysqli_stmt_init($link);

	if(!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: dBoard-Suppliers.php?Error=Unable to Add Supplier");
	}

	else {
		mysqli_stmt_bind_param($stmt, "s", $SupplierName);
		mysqli_stmt_execute($stmt);
		header("Location: dBoard-Suppliers.php");
		exit();
	}

} ?>

<?php if (isset($_GET["Edit"])) { 

		include "inc/dbh.inc.php";

		$SupplierID = $_GET["SupplierID"]; ?>

		<form method="post" action="dBoard-Suppliers.php?SaveChanges&ExistingSupplierID=<?php echo $SupplierID; ?>"> <?php

		$sql = "SELECT * FROM Suppliers WHERE SupplierID = $SupplierID;";
		$result = mysqli_query($link, $sql);
		$resultCheck = mysqli_num_rows($result);

		if ($resultCheck > 0) {
			while ($row = mysqli_fetch_assoc($result)) { ?>

				<div class="BoxInput Whole-Column">
					<label>Supplier ID</label>
					<input type="text" name="NewSupplierID" value="<?php echo $row['SupplierID']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Supplier Name</label>
					<input type="text" name="NewSupplierName" value="<?php echo $row['SupplierName']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Building</label>
					<input type="text" name="NewBuilding" value="<?php echo $row['Building']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Address Line 1</label>
					<input type="text" name="NewAddressLine1" value="<?php echo $row['AddressLine1']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Address Line 2</label>
					<input type="text" name="NewAddressLine2" value="<?php echo $row['AddressLine2']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>City</label>
					<input type="text" name="NewCity" value="<?php echo $row['City']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>State</label>
					<input type="text" name="NewState" value="<?php echo $row['State']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>ZipCode</label>
					<input type="text" name="NewZipCode" value="<?php echo $row['ZipCode']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Country</label>
					<input type="text" name="NewCountry" value="<?php echo $row['Country']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Phone</label>
					<input type="text" name="NewPhone" value="<?php echo $row['Phone']; ?>">
				</div>

				<div class="BoxInput Whole-Column">
					<label>Email</label>
					<input type="text" name="NewEmail" value="<?php echo $row['Email']; ?>">
				</div>

			<?php }
		}

		else {
			echo "It doesn't work!";
		} ?>

		<input type="submit" value="Save Changes">
	</form>

<?php } ?>

<?php if (isset($_GET["SaveChanges"])) {

	include "inc/dbh.inc.php";

	$NewSupplierID = mysqli_real_escape_string( $link, $_POST["NewSupplierID"]);
	$NewSupplierName = mysqli_real_escape_string( $link, $_POST["NewSupplierName"]);
	$NewBuilding = mysqli_real_escape_string( $link, $_POST["NewBuilding"]);
	$NewAddressLine1 = mysqli_real_escape_string( $link, $_POST["NewAddressLine1"]);
	$NewAddressLine2 = mysqli_real_escape_string( $link, $_POST["NewAddressLine2"]);
	$NewCity = mysqli_real_escape_string( $link, $_POST["NewCity"]);
	$NewState = mysqli_real_escape_string( $link, $_POST["NewState"]);
	$NewZipCode = mysqli_real_escape_string( $link, $_POST["NewZipCode"]);
	$NewCountry = mysqli_real_escape_string( $link, $_POST["NewCountry"]);
	$NewPhone = mysqli_real_escape_string( $link, $_POST["NewPhone"]);
	$NewEmail = mysqli_real_escape_string( $link, $_POST["NewEmail"]);

	$ExistingSupplierID = $_GET["ExistingSupplierID"];

	$sql = "UPDATE Suppliers SET SupplierID='".$NewSupplierID."', SupplierName='".$NewSupplierName."', Building='".$NewBuilding."', AddressLine1='".$NewAddressLine1."', AddressLine2='".$NewAddressLine2."', City='".$NewCity."', State='".$NewState."', ZipCode='".$NewZipCode."', Country='".$NewCountry."', Phone='".$NewPhone."', Email='".$NewEmail."' WHERE SupplierID='".$ExistingSupplierID."';";

	if (mysqli_query($link, $sql)) {
		header("Location: dBoard-Suppliers.php");
	}

	else {
		echo "Fail!";
	}

} ?>

<?php if(isset($_GET["Delete"])) {

	include "inc/dbh.inc.php";

	$SupplierID = $_GET['SupplierID'];

	$sql = "DELETE FROM Suppliers WHERE SupplierID=$SupplierID";

	if (mysqli_query($link, $sql)) {
		echo "Success!";
	}

	else {
		echo "Failed!";
	}

} ?>

</body>
</html>
