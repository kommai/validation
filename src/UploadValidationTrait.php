<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Kommai\Http\Upload;
use RuntimeException;

trait UploadValidationTrait
{
    // TODO: more validations
    // uploaded -> fail when the file is not uploaded (selected) UPLOAD_ERR_NO_FILE
    // completed -> fail when the file is partially uploaded UPLOAD_ERR_PARTIAL
    // smallEnough -> fail when the file size exceeds PHP limit UPLOAD_ERR_INI_SIZE
    // written -> fail when the file was not written UPLOAD_ERR_CANT_WRITE/UPLOAD_ERR_NO_TMP_DIR

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

    // TODO: bigger as well?
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
