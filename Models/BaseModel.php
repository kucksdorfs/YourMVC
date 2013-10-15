<?php

namespace MyMVC {
	use MyMVC\Reflection as Reflection;

	interface iBaseModel {
		public function Insert();
		public function Update();
		public function Delete();
		public function Fetch($criteria);
	}
	class BaseModel implements iBaseModel {
		protected $tableName = "";
		protected $children = array ();
		public function HelloWorld() {
			echo "Hello world!";
		}

		// Insert
		protected function BeforeCreate() {
		}
		protected function BeforeInsert() {
		}
		protected function AfterInsert() {
		}
		public function Insert() {
			parent::Insert ();
		}

		// Update
		protected function BeforeUpdate() {
		}
		protected function AfterUpdate() {
		}
		public function Update() {
			parent::Update ();
		}

		// Delete
		protected function BeforeDelete() {
		}
		protected Function AfterDelete() {
		}
		public function Delete() {
			parent::Delete ();
		}

		// Fetch
		protected function AfterFetch() {
		}
		public function Fetch($criteria) {
			parent::Fetch ( $criteria );
		}
		public function FetchByGUID($guid) {
			$criteria = $guid;
			parent::Fetch ( $criteria );
		}

		// Misc
		protected function Committed() {
		}
	}
}
