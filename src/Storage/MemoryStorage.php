<?php

require_once __DIR__ . '/StorageInterface.php';

class MemoryStorage implements StorageInterface {

	private $data = [];

	public function get($key) {

		if (!isset($this->data[$key])) {
			return null;
		}

		return $this->data[$key];
	}

	public function set($key, $value) {

		$this->data[$key] = $value;
	}

	public function delete($key) {

		unset($this->data[$key]);
	}
}