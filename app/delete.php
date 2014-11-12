<h3>Delete data from database</h3>
<form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="POST">
	What to delete
	<input type="text" name="data" width="20" />
	<input type="submit" value="Delete Data" /> </br>
	<i>hint: type ID for data to delete</i></br>
</form>
<?php
	if (isset($_POST["data"])) {
		if (!empty($_POST["data"])) {
			require_once("CommandDELETE.php");
			require_once("CommandInvoker.php");
			// Execute DELETE command
			$ci = new CommandInvoker(new CommandDELETE());
			$ci->process($_POST["data"]);
		} else {
			echo "<b>You must enter ID<b>  ";
		}
	}
?>
<a href="../index.php">Go back</a>