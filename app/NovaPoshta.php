<?php 

namespace App;

use LisDev\Delivery\NovaPoshtaApi2;

class NovaPoshta extends NovaPoshtaApi2 {

	protected $limit = 20;

	public function __construct($key, $language = 'ru', $throwErrors = false, $connectionType = 'curl')
    {
    	parent::__construct($key, $language = 'ru', $throwErrors = false, $connectionType = 'curl');
    }

    public function setLimit($limit) {
    	$this->limit = is_int($limit) ? $limit : $this->limit;
    }

    public function getLimit() {
    	return $this->limit;
    }

    public function getCity2($cityName) {

    	return $this
	    	->model('Address')
	    	->method('getCities')
	    	->params(array(
	    		'FindByString' => $cityName,
	    		"Limit" => $this->limit,
	    	))
	    	// ->model('Address')
	    	// ->method('searchSettlements')
	    	// ->params(array(
	    	// 	'CityName' => $cityName,
	    	// 	"Limit" => $this->limit,
	    	// ))
	    	->execute();
    }

    public function getWarehouses2($cityRef, $warehouseId = '', $limit = '30', $page = 0) {

    	return $this
	    	->model('Address')
	    	->method('getWarehouses')
	    	->params(array(
	    		'CityRef' => $cityRef,
	    		'WarehouseId' => $warehouseId,
	    		"Limit" => $limit,
	    	))
	    	->execute();
    }
}