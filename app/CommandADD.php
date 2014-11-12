<?php
	require_once("Command.php");
	require_once("appVars.php");
	require_once("TableGenerator.php");
	class CommandADD implements Command {
		public function execute($data) {
			$handle = fopen(DB_PATH, "r+");

			if (flock($handle, LOCK_EX)) { // Get lock
				$text = fread($handle, filesize(DB_PATH));
			    $rows = json_decode($text, true); // Decode JSON as array
				array_push($rows, (array)$data); // Update json
				$rows = json_encode($rows);
				// Write to file
				ftruncate($handle, 0);
				rewind($handle);
				fwrite($handle, $rows);
				flock($handle, LOCK_UN);    // Release the lock
				echo "</br><b>Row inserted.</b>";
				// Display row added
				$tg = new TableGenerator(array($data));
				$tg->getTable();
				
			} else {
		    	echo "Couldn't get the lock!";
			}
			fclose($handle);
		}
	}
?>