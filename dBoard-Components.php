<?php include "header.php"; ?>

<div class="WelcomeScreen">
	<a id="backTop" href="dBoard-Components.php">
		<img src="img/components.png">
	</a>
	<h3>Let's get going</h3>
	<p>Tap the button below to add your first component</p>
	<a href="dBoard-Components.php?Form">Add Component</a>
	<a href="dBoard-Components.php?ViewComponents">View Components</a>
</div>

<?php if (isset($_GET["ViewComponents"])) { ?>

	<table class="components_table">
		<tr>
			<th>ID</th>
			<th>Image</th>
			<th>Name</th>
			<th>SKU</th>
			<th>Cost</th>
			<th>Supplier</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>

	<?php require "inc/dbh.inc.php"; 

	$sql = "SELECT * FROM Components;";
	$result = mysqli_query($link, $sql);
	$resultCheck = mysqli_num_rows($result);

	if ($resultCheck > 0) {
		while ($row = mysqli_fetch_assoc($result)) { ?>

			<tr>
				<td><span><?php echo $row["ComponentID"]; ?></span></td>
				<td><img src="<?php echo $row['ComponentImg']; ?>"></td>
				<td><?php echo $row["ComponentName"]; ?></td>
				<td><?php echo $row["ComponentSKU"]; ?></td>
				<td><?php echo $row["ComponentCost"]; ?></td>
				<td><?php echo $row["ComponentSupplier"]; ?></td>
				<td><a href="dBoard-Components.php?EditForm&ComponentID=<?php echo $row['ComponentID']; ?>">Edit</a></td>
				<td><a href="dBoard-Components.php?Delete&ComponentID=<?php echo $row['ComponentID']; ?>">Delete</a></td>
			</tr>

		<?php }
	}

	else {
		echo "Either failed to view components or there are no components!";
	} ?>

	</table>

<?php } ?>

<?php if (isset($_GET["Form"])) { 

	require "inc/dbh.inc.php"; ?>

	<form method="post" action="dBoard-Components.php?AddComponent" class="dBoard-Form" id="dBoard-Add-Component">

		<div class="BoxInput Whole-Column">
			<label>Image</label>
			<input type="text" name="ComponentImg" placeholder="Enter a link to use for an image.">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Name</label>
			<input type="text" name="ComponentName" placeholder="Name">
		</div>

		<div class="BoxInput Whole-Column">
			<label>SKU</label>
			<input type="text" name="ComponentSKU" placeholder="SKU">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Cost</label>
			<input type="text" name="ComponentCost" placeholder="Cost">
		</div>

		<div class="BoxInput Whole-Column">
			<label>Supplier</label>
			<input type="text" name="ComponentSupplier" placeholder="Supplier">
		</div>

		<input type="submit" class="largeButton" value="Add Component">

	</form>

<?php } ?>

<?php if (isset($_GET["AddComponent"])) {

	include "inc/dbh.inc.php";

	$Image = mysqli_real_escape_string($link, $_POST["ComponentImg"]);
	$Name = mysqli_real_escape_string($link, $_POST["ComponentName"]);
	$SKU = mysqli_real_escape_string($link, $_POST["ComponentSKU"]);
	$Cost = mysqli_real_escape_string($link, $_POST["ComponentCost"]);
	$Supplier = mysqli_real_escape_string($link, $_POST["ComponentSupplier"]);

	$stmt = mysqli_prepare($link, "INSERT INTO Components (ComponentImg, ComponentName, ComponentSKU, ComponentCost, ComponentSupplier) VALUES (?,?,?,?,?)");

	mysqli_stmt_bind_param($stmt, "sssss", $Image, $Name, $SKU, $Cost, $Supplier);
	mysqli_stmt_execute($stmt);

	mysqli_stmt_close($stmt);

	echo "Successfully written to the database!";

} ?>

<?php if (isset($_GET["EditForm"])) {

	include "inc/dbh.inc.php"; 

	$ComponentID = mysqli_real_escape_string($link, $_GET["ComponentID"]);

	if ($stmt = mysqli_prepare($link, "SELECT * FROM Components WHERE ComponentID=?")) {

		mysqli_stmt_bind_param($stmt, "s", $ComponentID);
		mysqli_stmt_execute($stmt);

		mysqli_stmt_store_result($stmt);

		mysqli_stmt_bind_result($stmt, $Fetch_ID, $Fetch_Img, $Fetch_Name, $Fetch_SKU, $Fetch_Cost, $Fetch_Supplier);

		$resultCheck = mysqli_stmt_num_rows($stmt);

		if ( $resultCheck > 0 ) {

			// printf("The number of rows is: %s", mysqli_stmt_num_rows($stmt));

			while (mysqli_stmt_fetch($stmt)) {
				//printf("You are looking for this: %s, %s, %s, %s, %s, %s", $Fetch_ID, $Fetch_Img, $Fetch_Name, $Fetch_SKU, $Fetch_Cost, $Fetch_Supplier); ?>

				<form method="post" action="dBoard-Components.php?SaveEdit&ComponentID=<?php echo $ComponentID; ?>" class="dBoard-Form" id="dBoard-Edit-Component">
					<div class="BoxInput Whole-Column">
						<label>Component ID</label>
						<input type="text" name="Update_Component_ID" value="<?php printf('%s', $Fetch_ID); ?>">
					</div>

					<div class="BoxInput Whole-Column">
						<label>Component Image URL</label>
						<input type="text" name="Update_Img" value="<?php printf('%s', $Fetch_Img); ?>">
					</div>

					<div class="BoxInput Whole-Column">
						<label>Component Name</label>
						<input type="text" name="Update_Name" value="<?php printf('%s', $Fetch_Name); ?>">
					</div>

					<div class="BoxInput Whole-Column">
						<label>Component SKU</label>
						<input type="text" name="Update_SKU" value="<?php printf('%s', $Fetch_SKU); ?>">
					</div>

					<div class="BoxInput Whole-Column">
						<label>Component Cost</label>
						<input type="text" name="Update_Cost" value="<?php printf('%s', $Fetch_Cost); ?>">
					</div>

					<div class="BoxInput Whole-Column">
						<label>Component Supplier</label>
						<input type="text" name="Update_Supplier" value="<?php printf('%s', $Fetch_Supplier); ?>">
					</div>

					<input type="submit" class="largeButton" value="Save Changes">

				</form>

			<?php }

		}

		else {
			printf("There are no rows found!");
		}

	}

	else {
		echo "Whuuuuh?";
	}

} ?>

<?php if (isset($_GET["SaveEdit"])) {

	require "inc/dbh.inc.php";

	$ComponentID = mysqli_real_escape_string($link, $_GET["ComponentID"]);

	$secrets_are_bad = "sorry";

	$Update_Component_ID = mysqli_real_escape_string($link, $_POST["Update_Component_ID"]);
	$Update_Img = mysqli_real_escape_string($link, $_POST["Update_Img"]);
	$Update_Name = mysqli_real_escape_string($link, $_POST["Update_Name"]);
	$Update_SKU = mysqli_real_escape_string($link, $_POST["Update_SKU"]);
	$Update_Cost = mysqli_real_escape_string($link, $_POST["Update_Cost"]);
	$Update_Supplier = mysqli_real_escape_string($link, $_POST["Update_Supplier"]);

	if ($stmt = mysqli_prepare($link, "UPDATE Components SET ComponentID=?, ComponentImg=?, ComponentName=?, ComponentSKU=?, ComponentCost=?, ComponentSupplier=? WHERE ComponentID=?")) {

		mysqli_stmt_bind_param($stmt, "sssssss", $Update_Component_ID, $Update_Img, $Update_Name, $Update_SKU, $Update_Cost, $Update_Supplier, $ComponentID);
		mysqli_stmt_execute($stmt);

		printf("Good job. &#128521;");

	}

	else {
		printf("This doesn't work, %s!", $secrets_are_bad);
	}

} ?>

<?php if (isset($_GET["Delete"])) {

	require "inc/dbh.inc.php";

	$ComponentID = mysqli_real_escape_string($link, $_GET["ComponentID"]);

	if ($stmt = mysqli_prepare($link, "DELETE FROM Components WHERE ComponentID=?")) {
		mysqli_stmt_bind_param($stmt, "s", $ComponentID);
		mysqli_stmt_execute($stmt);
		printf("You have successfully deleted the row.");
	}

	else {
		printf("It doesn't work!");
	}

} ?>