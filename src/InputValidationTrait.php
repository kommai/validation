<?php

declare(strict_types=1);

namespace Kommai\Validation;

trait InputValidationTrait
{
    public function filled(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return strval($value) !== '';
            },
            'error' => $error,
        ];
        return $this;

        // and so on...
    }
}
