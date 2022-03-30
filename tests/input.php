<?php

declare(strict_types=1);

use Kommai\Validation\InputValidationTrait;
use Kommai\Validation\ValidatorTrait;

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
    'name' => 'Alice',
];

$validator = new ExampleInputValidator();
//$validator->filled(0, 'must be filled');
//$validator->filled('X', 'must be filled');
$validator
->filled('name', 'must be filled')
//->equal('name', 'Alice', 'must be Alice')
;

var_dump($validator->validate($data));
