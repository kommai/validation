<?php

declare(strict_types=1);

namespace Kommai\Validation;

trait StringValidationTrait
{
    private function filled(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return strval($value) !== '';
            },
            'error' => $error,
        ];
        return $this;
    }

    private function longer(int|string $key, int $length, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($length) {
                return mb_strlen((string) $value) > $length;
            },
            'error' => $error,
        ];
        return $this;
    }

    private function shorter(int|string $key, int $length, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($length) {
                return mb_strlen((string) $value) < $length;
            },
            'error' => $error,
        ];
        return $this;
    }
}
