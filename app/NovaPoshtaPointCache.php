<?php
namespace App;

class NovaPoshtaPointCache extends NovaPoshtaCache {

	protected $path = 'cache/point.json';

	public function __construct() {
		parent::__construct($this->path);
	}

	public function getCache($name) {
		// $new_data = [];
		// $i = 0;
		// foreach ($this->data as $key => $val) {
		// 	if($i == $this->count) break;
		// 	if( mb_stripos($val['city'], $name) === false) continue;
		// 	$new_data[] = $val;
		// 	$i++;
		// }
		// return $new_data;
		 return false;
	}

	public function setCache($data, $cityRef) {
		if(is_array($this->data) && is_array($data) && !empty($cityRef)) {
			// if (array_key_exists($cityRef, $this->data)) {
				$new_data = array_unique(array_merge($this->data, [$cityRef => $data]), SORT_REGULAR);
			// } else {
			// 	$this->data[$cityRef] = $data;
			// 	$new_data = $this->data;
			// }
			// array_merge_recursive()
			// var_dump( $new_data ); exit;
			$this->saveFileContents($new_data);			
		}
	}
}