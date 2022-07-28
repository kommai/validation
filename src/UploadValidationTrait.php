<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Kommai\Http\Upload;
use RuntimeException;

trait UploadValidationTrait
{
    private function smallEnough(int|string $key, string $error): self
    {
        /*
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) {
                return $upload->error !== UPLOAD_ERR_INI_SIZE;
            },
            'error' => $error,
        ];
        return $this;
        */
        return $this->addRule($key, function (Upload $upload) {
            return $upload->error !== UPLOAD_ERR_INI_SIZE;
        }, $error);
    }

    private function completed(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) {
                return $upload->error !== UPLOAD_ERR_PARTIAL;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function filled(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) {
                return $upload->error !== UPLOAD_ERR_NO_FILE;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function written(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) {
                return $upload->error !== UPLOAD_ERR_NO_TMP_DIR && $upload->error !== UPLOAD_ERR_CANT_WRITE;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function bigger(int|string $key, int $size, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function (Upload $upload) use ($size) {
                return $upload->size > $size;
            },
            'error' => $error,
        ];
        return $this;
    }

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
