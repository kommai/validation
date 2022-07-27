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
        $this->shorter('name', 15, 'Too long');
        $this->filled('likes', 'Must be filled');
        $this->shorter('likes', 15, 'Too long');
        return parent::__invoke($data);
    }
};

$data = [
    'name' => 'Alice',
    //'name' => '',
    'likes' => ['Apple', 'Book', 'Computer'],
];

$errors = $validation->__invoke($data);
if (!$errors) {
    echo 'Validation passed!', PHP_EOL;
} else {
    echo 'Validation failed; error(s):', PHP_EOL;
    var_dump($errors);
}
