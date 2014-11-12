<?php
	require_once("Command.php");
	require_once("appVars.php");
	class CommandDELETE implements Command {
		public function execute($data) {
			$handle = fopen(DB_PATH, "r+");

			if (flock($handle, LOCK_EX)) { // Get lock
				$text = fread($handle, filesize(DB_PATH));
			    $rows = json_decode($text, true); // Decode as array
			    $counter = 0;
			    // Remove row
				foreach ($rows as $row) {
				    if ($data == $row["id"]) {
				        unset($rows[$counter]);
				        break;
				    }
				    $counter++;
				}
				// normalize integer keys
				$rows = array_values($rows);
				$rows = json_encode($rows);
				// write to file
				ftruncate($handle, 0);
				rewind($handle);
				fwrite($handle, $rows);
				echo "</br><b>Row deleted.</b>";
				flock($handle, LOCK_UN);    // release the lock
				
			} else {
		    	echo "Couldn't get the lock!";
			}
			fclose($handle);
		}
	}
?>

		