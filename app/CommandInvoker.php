<?php
	require_once("Command.php");
	// Gets query and invoke CRUD command
	class CommandInvoker {
		private $rule;

		public function __construct(Command $rule) {
			$this->rule = $rule;
		}

		// Invoke CRUD command
		public function process($data) {
			$this->rule->execute($data);
		}
	}