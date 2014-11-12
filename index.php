<html>
	<head>
		<title>Task: CRUD Database</title>
	</head>
	<body>
		<h3>CRUD Database</h3>
		<a href="app/add.php">Add entry</a></br>
		<a href="app/get.php">Get entry</a></br>
		<a href="app/update.php">Update entry</a></br>
		<a href="app/delete.php">Delete entry</a></br>
		<?php
		require_once("app/TableGenerator.php");
		require_once("app/appVars.php");
		$handle = fopen(DB_PATH, "r+");
		if (flock($handle, LOCK_EX)) { // get lock
			$text = fread($handle, filesize(DB_PATH));
		    $rows = json_decode($text, true); // decode as array
		  	$tg = new TableGenerator($rows);
		  	$tg->getTable();
		  	flock($handle, LOCK_UN);    // release the lock
		} else {
		 	echo "Couldn't get the lock!";
		}
		fclose($handle);
		?>
	</body>
</html>