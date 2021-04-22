<?php

require_once('../vendor/autoload.php');

$kourses = new Kourses\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

$products = $kourses->products->all(['per_page' => 2]);

$products->each(function ($product) {
    var_dump($product->title);
});

var_dump($products->getTotal());