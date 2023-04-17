<?php

namespace App;

abstract class NovaPoshtaCache {

	// protected $file_path = ['city'=>'cache/city.json', 'point'=>'cache/point.json'];

	protected $file;

	protected $alias = 'city';

	protected $data;

	protected $count = 20;

	public function __construct($path) {
		// $file_path = $this->getPath($path);
		$this->file = @fopen($path, "c+") or die("не удалось открыть файл");
		$this->getFileContents();
	}

	// public function getPath($path) {
	// 	if(array_key_exists($path, $this->file_path)) {
	// 		return $this->file_path[$path];
	// 	}
	// 	exit('city or point'); 
	// }

	public function __destruct() {
		fclose($this->file);
	}

	public function getFileContents() {
		$contents = fgets($this->file);
		$this->data = $contents ? json_decode($contents, true) : [];
		return $this->data;
	}

	public function saveFileContents($data) {
		rewind($this->file);
		fwrite($this->file, json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	abstract public function getCache($name);

	abstract public function setCache($data, $id);

	// public function getCache($name) {
	// 	$new_data = [];
	// 	$i = 0;
	// 	foreach ($this->data as $key => $val) {
	// 		if($i == $this->count) break;
	// 		if( mb_stripos($val['city'], $name) === false) continue;
	// 		$new_data[] = $val;
	// 		$i++;
	// 	}
	// 	return $new_data;
	// }

	// public function setCache($data) {
	// 	if(is_array($this->data) && is_array($data)) {
	// 		$new_data = array_unique(array_merge($this->data, $data), SORT_REGULAR);
	// 		$this->saveFileContents($new_data);			
	// 	}
	// }

	public function setCount($count) {
		$this->count = (int)$count;
	}

}
