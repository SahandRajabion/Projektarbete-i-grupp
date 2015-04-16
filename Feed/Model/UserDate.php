<?php

	class UserDate {

		private $date;

		public function __construct($date) {
			$this->date = $date;
		}


		public function getDate() {
			return $this->date;
		} 
	}