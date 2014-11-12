<?php
	require_once("Command.php");
	require_once("appVars.php");
	require_once("TableGenerator.php");
	class CommandGET implements Command {
		public function execute($data) {
			// If ALL is requested
			if ("all" == strtolower($data)) {
				$this->getResult("all");
			}
			else {
				// If ID is requested
				$this->getResult($data);
			}
		}

		// Find result by query and display it
		public function getResult($query) {
			$handle = fopen(DB_PATH, "r+");

				if (flock($handle, LOCK_EX)) { // Get lock
					$text = fread($handle, filesize(DB_PATH));
				    $json = json_decode($text, true); // Decode as array
					
				    if ("all" == $query) {
				    	// Render whole database
					    $tg = new TableGenerator($json);
					    $tg->getTable(); 
					} else {
						// If data found, show it
						$found = false;
						foreach($json as $row) {
							if ($row["id"] == $query) {
								// Print table row
								$tg = new TableGenerator(array($row));
								$tg->getTable();
								$found = true;
								break;
							}
						}
						if (!$found) {
							echo "No such record.</br>";
						}
					}
				    flock($handle, LOCK_UN);    // Release the lock
				} else {
			    	echo "Couldn't get the lock!";
				}

				fclose($handle);
		}
	}