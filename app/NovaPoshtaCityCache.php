<?php
namespace App;

class NovaPoshtaCityCache extends NovaPoshtaCache {

	protected $path = 'cache/city.json';

	public function __construct() {
		parent::__construct($this->path);
	}

	public function getCache($name) {
		$new_data = [];
		$i = 0;
		foreach ($this->data as $key => $val) {
			if($i == $this->count) break;
			if( mb_stripos($val['city'], $name) === false) continue;
			$new_data[] = $val;
			$i++;
		}
		return $new_data;
	}

	public function setCache($data, $id='') {
		if(is_array($this->data) && is_array($data) && !empty($data)) {
			$new_data = array_unique(array_merge($this->data, $data), SORT_REGULAR);
			$this->saveFileContents($new_data);			
		}
	}
}