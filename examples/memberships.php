<?php

require_once('../vendor/autoload.php');

$kourses = new KoursesPhp\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

$memberships = $kourses->memberships->all(['per_page' => 2]);

$memberships->each(function ($membership) {
    var_dump($membership->name);
});

var_dump($memberships->getTotal());