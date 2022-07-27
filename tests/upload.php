<?php

declare(strict_types=1);

use Kommai\Http\Upload;
use Kommai\Validation\UploadValidationTrait;
use Kommai\Validation\Validation;
use Kommai\Validation\ValidationInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$validation = new class extends Validation implements ValidationInterface
{
    use UploadValidationTrait;

    public function __invoke(array $data): array
    {
        $this->smaller('file', 1001, 'Too big');
        //$this->type('file', 'image/jpeg', 'Invalid or unknown type'); // this should fail for non-actual uploaded file
        return parent::__invoke($data);
    }
};

$uploads = [
    'file' => new Upload('file.jpg', 'image/jpeg', 'temp', 0, 1000),
];
//var_dump($uploads);

$errors = $validation->__invoke($uploads);
if (!$errors) {
    echo 'Validation passed!', PHP_EOL;
} else {
    echo 'Validation failed; error(s):', PHP_EOL;
    var_dump($errors);
}
