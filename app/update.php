<h3>Update row</h3>
<form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="POST">
	<?php
		require_once("Command.php");
		require_once("CommandInvoker.php");
		require_once("appVars.php");

		$handle = fopen(DB_PATH, "r+");

		if (flock($handle, LOCK_EX)) { // Get lock
			$text = fread($handle, filesize(DB_PATH));
		    $rows = json_decode($text, true); // Decode as array
		    ?>
		    <table>
		    	<tr>
		    		<td align="right">ID:</td><td><input type="text" name="id" width="20" /></td>
		    	</tr>
		    	<tr>
		    		<td align="right">Field:</td><td><input type="text" name="field" width="20" /></td>
		    	</tr>
		    	<tr>
		    		<td align="right">New Value:</td><td><input type="text" name="newValue" width="20" /></td>
		    	</tr>
		    </table>
		    <?php
		    flock($handle, LOCK_UN);    // Release the lock	
		} else {
	    	echo "Couldn't get the lock!";
		}
		fclose($handle);
	?>
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	<a href="../index.php">Go back</a>
	<input type="submit" name="submit" value="Update Data" />
</form>
<?php
	if (isset($_POST["submit"])) {
		require_once("CommandUPDATE.php");
		require_once("CommandInvoker.php");
		// Check for empty HTML input fields
		if (!empty($_POST["id"]) && !empty($_POST["field"])
			 && !empty($_POST["newValue"])) {
			$ci = new CommandInvoker(new CommandUPDATE());
			// Prepare data for Invoker
			$o = new StdClass();
			$o->id = uniqid();
			foreach($_POST as $key => $value) {
				if ($key != "submit") {
					$property = $key . '';
					$o->$property = $value;
				}
			}
			// Invoker process UPDATE command
			$ci->process($o);
		} else {	
			echo "You must enter all fields";
		}
	}
?>
