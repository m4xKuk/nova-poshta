<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Delivery;

if (!isset($_GET['term'])) exit;

$np = new Delivery();

$term = trim(strip_tags($_GET['term']));
$is_cache = $_GET['is_cache'];

if (isset($_GET['sender_city'])) {
	echo json_encode($cities = $np->getCity($term, $is_cache=true));

}
if (isset($_GET['sender_point']) && isset($_GET['sender_city_ref'])) {
	$ref = $_GET['sender_city_ref'];
	echo json_encode($np->getWarehouses($ref, $term, $is_cache=true));
}
