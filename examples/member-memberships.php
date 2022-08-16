<?php

require_once('../vendor/autoload.php');

$kourses = new KoursesPhp\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

// $memberships = $kourses->membermemberships->all(['member' => 'bdade8a4']);
$memberships = $kourses->membermemberships->all(['member' => 'api.dummy@example.com', 'per_page' => 1]);

var_dump($memberships);