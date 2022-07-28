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
        // $this->smallEnough('file', 'The uploaded file exceeds the upload_max_filesize directive in php.ini');
        // $this->completed('file', 'The uploaded file was only partially uploaded');
        // $this->filled('file', 'No file was uploaded');
        // $this->written('file', 'Missing a temporary folder | Failed to write file to disk');
        // $this->smaller('file', 1001, 'Too big');
        //$this->type('file', 'image/gif', 'Invalid or unknown type'); // this should fail for non-actual uploaded file
        //$this->type('file', ['image/gif', 'image/jpeg', 'image/png'], 'Invalid or unknown type'); // this should fail for non-actual uploaded file
        return parent::__invoke($data);
    }
};
//var_dump($validation);

$uploads = [
    'file' => new Upload('file.jpg', 'text/plain', 'temp', UPLOAD_ERR_OK, 1000),
];
//var_dump($uploads);

$errors = $validation->__invoke($uploads);
if (!$errors) {
    echo 'Validation passed!', PHP_EOL;
} else {
    echo 'Validation failed; error(s):', PHP_EOL;
    var_dump($errors);
}
