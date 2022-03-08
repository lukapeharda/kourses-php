<?php

require_once('../vendor/autoload.php');

$kourses = new KoursesPhp\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

// $products = $kourses->memberProducts->all(['member' => 'bdade8a4']);
$products = $kourses->memberProducts->all(['member' => 'api.dummy@example.com', 'per_page' => 1]);

var_dump($products);