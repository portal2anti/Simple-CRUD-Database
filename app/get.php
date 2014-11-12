<h3>Retrieving data from database</h3>
<form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="POST">
	What to get
	<input type="text" name="data" width="20" />
	<input type="submit" value="Get Data" /> </br>
	<i>hint: type ALL for all data</i></br>
	<i>hint: type ID for row data</i>
</form>
<?php
	if (isset($_POST["data"])) {
		require_once("CommandGET.php");
		require_once("CommandInvoker.php");
		// Execute GET command
		$ci = new CommandInvoker(new CommandGET());
		$ci->process($_POST["data"]);
	}
?>
<a href="../index.php">Go back</a>