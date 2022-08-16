<?php

require_once('../vendor/autoload.php');

$kourses = new KoursesPhp\Client();

$kourses->setApiKey('GENERATED_API_TOKEN');
$kourses->setApiBaseUrl('http://app.kourses.local/api/');

try {
    $member = $kourses->members->create([
        'email' => 'api.dummy@example.com',
        // 'memberships' => [
        //     '8b6a9ba4'
        // ],
    ]);

    var_dump($member);
    var_dump($member->memberships->first()->title);
} catch (KoursesPhp\Exception\ValidationException $exception) {
    $errors = $exception->getErrorBag();

    var_dump($errors->first('email'));
}