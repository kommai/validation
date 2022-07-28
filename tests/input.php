<?php

declare(strict_types=1);

use Kommai\Validation\CustomValidationTrait;
use Kommai\Validation\StringValidationTrait;
use Kommai\Validation\Validation;
use Kommai\Validation\ValidationInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$validation = new class extends Validation implements ValidationInterface
{
    use StringValidationTrait, CustomValidationTrait;

    public function __invoke(array $data): array
    {
        $this->filled('name', 'Must be filled');
        $this->filled('email', 'Must be filled');
        $this->filled('password', 'Must be filled');
        $this->filled('postal', 'Must be filled');
        return parent::__invoke($data);
    }
};


$data = [
    'name' => 'Alice',
    'email' => 'alice@example.com.123',
    //'url' => 'example.com',
    'password' => '12345678',
    'postal' => '730-0854',
];

$errors = $validation->__invoke($data);
if (!$errors) {
    echo 'Validation passed!', PHP_EOL;
} else {
    echo 'Validation failed; error(s):', PHP_EOL;
    var_dump($errors);
}
