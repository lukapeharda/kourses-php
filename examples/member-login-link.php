<?php

require_once('../vendor/autoload.php');

$kourses = new Kourses\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

try {
    $loginLink = $kourses->memberLoginLink->create(['member' => 'api.dummy@example.com', 'redirects' => 'account/profile']);

    var_dump($loginLink);
} catch (Exception $exception) {
    var_dump($exception);
}