<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Kommai\Http\Upload;
use RuntimeException;

trait UploadValidationTrait
{
    private function smaller(int|string $key, int $size, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) use ($size) {
                return $upload->size < $size;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function type(int|string $key, string $type, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) use ($type) {
                if (!is_readable($upload->temp)) {
                    throw new RuntimeException('The uploaded file is unavailable');
                }
                return mime_content_type($upload->temp) === $type;
            },
            'error' => $error,
        ];
        return $this;
    }
}
