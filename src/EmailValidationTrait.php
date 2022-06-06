<?php

declare(strict_types=1);

namespace Kommai\Validation;

trait EmailValidationTrait
{
    private function email(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            },
            'error' => $error,
        ];
        return $this;
    }
}
