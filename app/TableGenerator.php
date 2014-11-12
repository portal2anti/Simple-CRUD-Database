<style>
	table, th, td {
	    border: 1px solid black;
	    border-collapse: collapse;
	}
	th, td {
	    padding: 5px;
	    text-align: left;
	}
</style>
<?php
// Generate HTML Table with $data
class TableGenerator {
	// Holds table contents
	public $data;

	// Get table array
	public function __construct($data) {
		$this->data = $data;
	}

	public function getTable() {
		$first_row = array_shift($this->data);
		array_unshift($this->data, $first_row);
		// Holds header names
		$theaders = array();
		foreach($first_row as $key => $value) {
			array_push($theaders, $key);
		}

		// Holds data in HTML 
		$result = "<table><tr>";
		// Add headers to HTML Table
		for ($i = 0; $i < count($theaders); $i++) {
			$result = $result . "<th>" . $theaders[$i] . "</th>";
		}
		$result = $result . "</tr>";
		// Now add some rows of data
		foreach($this->data as $row) {
			$result = $result . "<tr>";
			foreach($row as $el) {
				$result = $result . "<td>" . $el . "</td>";
			}
			$result = $result . "</tr>";
		}
		$result = $result . "</table>";
		// Display HTML Table
		echo $result;
	}
}
?>
