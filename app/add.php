<h3>Insert data into database</h3>
<form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="POST">
	<?php
		require_once("Command.php");
		require_once("CommandInvoker.php");
		require_once("appVars.php");
		$fKeys = array(); // Field keys
		$handle = fopen(DB_PATH, "r+");

		if (flock($handle, LOCK_EX)) { // Get lock
			$text = fread($handle, filesize(DB_PATH));
		    $rows = json_decode($text, true); // Decode JSON as array
		    $firstRow = array_shift($rows);
		    array_unshift($rows, $firstRow);
		    foreach ($firstRow as $key => $value) {
		    	if ($key != "id") {
		    		// Save field keys for later
		    		array_push($fKeys, $key);
		    		// and create input fields
			    	echo "<b>" . $key;
			    	?>
			    	<input type="text" name="<?php echo $key . ''; ?>" width="20" /></br>
			    	<?php 
		    	}
		    }
			flock($handle, LOCK_UN);    // Release the lock	
		} else {
	    	echo "Couldn't get the lock!";
		}
		fclose($handle);
	?>
	<input type="submit" name="submit" value="Insert Data" /> </br>
</form>
<?php
	if (isset($_POST["submit"])) {
		require_once("CommandADD.php");
		require_once("CommandInvoker.php");
		// check for empty fields
		$dataOk = true;
		foreach ($fKeys as $key) {
			if(empty($_POST[$key])) {
				$dataOk = false;
			}
		}
		if ($dataOk == true) {
			$ci = new CommandInvoker(new CommandADD());
			// Prepare data object for invoker
			$o = new StdClass();
			$o->id = uniqid(); // Create unique ID
			foreach($_POST as $key => $value) {
				if ($key != "submit") {
					$property = $key . '';
					$o->$property = $value;
				}
			}
			$ci->process($o);
		} else {
			echo "Please fill ALL fields  ";
		}
	}
?>
<a href="../index.php">Go back</a>