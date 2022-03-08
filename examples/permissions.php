<?php

require_once('../vendor/autoload.php');

$kourses = new KoursesPhp\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

$status = $kourses->permissions->create([
    'member' => 'bdade8a4',
    'product' => '7dbae9a4',
]);

var_dump($status);

$status = $kourses->permissions->delete([
    'member' => 'bdade8a4',
    'product' => '7dbae9a4',
    'ends_at' => '2021-05-05',
]);

var_dump($status);