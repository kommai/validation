<?php

declare(strict_types=1);

use Kommai\Validation\InputValidationTrait;
use Kommai\Validation\ValidatorTrait;
use Kommai\TestKit\Proxy;

require_once __DIR__ . '/../vendor/autoload.php';

class ExampleInputValidator
{
    use ValidatorTrait;
    use InputValidationTrait;
}

$data = [
    'foo',
];

$data = [
    'name' => '',
    'email' => 'alice@example.com.123',
    //'url' => 'example.com',
    'password' => '12345678',
    'postal' => '730-0854',
];

$validator = new ExampleInputValidator();
//$validator->filled(0, 'must be filled');
//$validator->filled('X', 'must be filled');
$validator->filled('name', 'must be filled')->equal('name', 'Alice', 'must be Alice');
$validator->filled('email', 'must be filled')->email('email', 'invalid');
if (isset($data['url'])) {
    $validator->url('url', 'invalid');
}
$validator->filled('password', 'must be filled')->longer('password', 4 - 1, 'too short')->shorter('password', 8 + 1, 'too long');
$validator->filled('postal', 'must be filled')->regex('postal', '/\A[0-9]{7}\z/', 'invalid');

$validatorProxy = new Proxy($validator);
//var_dump($validatorProxy->rules);

var_dump($validator->validate($data));
