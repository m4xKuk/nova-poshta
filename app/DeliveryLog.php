<?php

namespace App;

class DeliveryLog {

	private $path = 'log.txt';

	private $file;

	private $count = ['api'=>0, 'cache'=>0];

	public function __construct() {
		$this->file = fopen($this->path, "c+");
		$result = fgets($this->file);
		$this->count = $result ? json_decode($result, true) : $this->count;
	}

	public function getCount() {
		return $this->count;
	}

	// flag = api or cache
	public function setCount($flag) {
		if(in_array($flag, array_keys($this->count))) {
			$this->count[$flag]++;
			rewind($this->file);
			fwrite($this->file, json_encode($this->count));
		}
	}

	public function __destruct() {
		fclose($this->file);
	}
}


// $d = new DeliveryLog();
// $d->setCount('api');