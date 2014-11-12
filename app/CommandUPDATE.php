<?php
	require_once("Command.php");
	require_once("appVars.php");
	class CommandUPDATE implements Command {
		public function execute($data) {
			$handle = fopen(DB_PATH, "r+");

			if (flock($handle, LOCK_EX)) { // Get lock
				$text = fread($handle, filesize(DB_PATH));
			    $rows = json_decode($text, true); // Decode as array
				// Now i need to update query field
				for($i = 0; $i < count($rows); $i++) {
					if ($rows[$i]["id"] == $data->id) {
						// Check if field actually exists
						if (empty($rows[$i][$data->field])) { 
							echo "No such field";
							return;
						} else {
							// Update field
							$rows[$i][$data->field] = $data->newValue;
							break;
						}
					}
				}
				$rows = json_encode($rows);
				// write to file
				ftruncate($handle, 0);
				rewind($handle);
				fwrite($handle, $rows);
				echo "</br><b>Row updated.<b>";
				flock($handle, LOCK_UN);    // Release the lock
				
			} else {
		    	echo "Couldn't get the lock!";
			}
			fclose($handle);
		}
	}
?>