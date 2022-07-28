<?php

declare(strict_types=1);

namespace Kommai\Validation;

use Kommai\Http\Upload;
use RuntimeException;

trait UploadValidationTrait
{
    private function smallEnough(int|string $key, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) {
            return $upload->error !== UPLOAD_ERR_INI_SIZE;
        }, $error);
    }

    private function completed(int|string $key, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) {
            return $upload->error !== UPLOAD_ERR_PARTIAL;
        }, $error);
    }

    private function filled(int|string $key, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) {
            return $upload->error !== UPLOAD_ERR_NO_FILE;
        }, $error);
    }

    private function written(int|string $key, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) {
            return $upload->error !== UPLOAD_ERR_NO_TMP_DIR && $upload->error !== UPLOAD_ERR_CANT_WRITE;
        }, $error);
    }

    private function bigger(int|string $key, int $size, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) use ($size) {
            return $upload->size > $size;
        }, $error);
    }

    private function smaller(int|string $key, int $size, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) use ($size) {
            return $upload->size < $size;
        }, $error);
    }

    private function type(int|string $key, string|array $type, string $error): self
    {
        return $this->addRule($key, function (Upload $upload) use ($type) {
            if (!is_readable($upload->temp)) {
                throw new RuntimeException('The uploaded file is unavailable');
            }

            $mime = mime_content_type($upload->temp); // this is BETTER
            //$mime = $upload->type;
            if (is_array($type)) {
                return in_array($mime, $type, true);
            }
            return $mime === $type;
        }, $error);
    }
}
