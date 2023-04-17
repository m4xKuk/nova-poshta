<?php

namespace App;

use App\NovaPoshta;
use App\NovaPoshtaCache;
use App\DeliveryLog;

class Delivery {

	public $provide;

	// public $cache;

	public $log;

	public $data = [];

	public $error = ['value'=>'Нет данных'];

	public function __construct() {
		$env = parse_ini_file('.env');
		$this->provide = new NovaPoshta($env['KEY']);
		$this->log = new DeliveryLog();
	}

	public function getCity($name, $is_cache) {
		$cache = new NovaPoshtaCityCache();

		// print_r( $this->provide->getCity2($name) ); exit;

		if( ($data = $cache->getCache($name)) && $is_cache) {
		 	$this->log->setCount('cache');
		 	return $data;
		} else {
		 	$this->log->setCount('api');
		 	if( ($data = $this->getCityDataApi($name)) ) {
		 		$cache->setCache($data);
				return $data;
		 	}
		 	return $this->error;
		}
		// return $this->getCityData($name);
	}

	public function getWarehouses($cityRef, $point_id, $is_cache) {
		$cache = new NovaPoshtaPointCache();
		// return $this->provide->getWarehouses2($ref, $point_id);
		// if( ($data = $this->getPointDataApi($cityRef, $point_id)) ) {
		// 	return $data;
		// }
		// return $this->error;
		
		if( ($data = $cache->getCache($cityRef, $point_id)) ) {
		 	$this->log->setCount('cache');
		 	return $data;
		} else {
		 	$this->log->setCount('api');
		 	if( ($data = $this->getPointDataApi($cityRef, $point_id)) ) {
		 		$cache->setCache($data, $cityRef);
				return $data;
		 	}
		 	return $this->error;
		}
	}

	public function getCityDataApi($name) {
		$result = $this->provide->getCity2($name);
		if ( !empty($result['data']) && is_array($result['data'])) {
			foreach ($result['data'] as $i=>$city) {
				$this->data[$i]['value'] = $city['SettlementTypeDescription']. ' ' . $city['Description'] . ', ' . $city['AreaDescription'] . ' обл.';
				// $this->data[$i]['value'] = $city['Present'];
				$this->data[$i]['ref'] = $city['Ref'];
				$this->data[$i]['city'] = $city['Description'].'|'.$city['DescriptionRu'];
			}
			return $this->data;
		}
		return false;
	}

	public function getPointDataApi($cityRef, $data) {
		$result = $this->provide->getWarehouses2($cityRef, $data);
		if ( !empty($result['data']) && is_array($result['data'])) {
			foreach ($result['data'] as $i=>$point) {
				$this->data[$i]['value'] = $point['Description'];
				$this->data[$i]['ref'] = $point['Ref'];
			}
			return $this->data;
		}
		return false;
	}
}