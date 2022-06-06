<?php

declare(strict_types=1);

namespace Kommai\Validation;

trait UrlValidationTrait
{
    private function url(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            },
            'error' => $error,
        ];
        return $this;
    }
}
