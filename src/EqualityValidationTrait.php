<?php

declare(strict_types=1);

namespace Kommai\Validation;

trait EqualityValidationTrait
{
    private function equal(int|string $key, mixed $target, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($target) {
                return $value === $target;
            },
            'error' => $error,
        ];
        return $this;
    }
}
