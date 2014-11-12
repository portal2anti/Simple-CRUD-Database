<?php
	// Interface for CRUD commands
	interface Command {
		// Performs desired CRUD command
		// $data - data needed to perform command
		public function execute($data);
	}
?>