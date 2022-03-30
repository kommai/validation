<?php

declare(strict_types=1);

namespace Kommai\Validation;

use RuntimeException;

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
    }

    public function equal(int|string $key, mixed $target, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($target) {
                return $value === $target;
            },
            'error' => $error,
        ];
        return $this;
    }

    public function regex(int|string $key, string $pattern, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($pattern) {
                $result = preg_match($pattern, $value);
                if ($result === false) {
                    throw new RuntimeException('Failed to complete a match');
                }
                return $result === 1;
            },
            'error' => $error,
        ];
        return $this;
    }

    public function longer(int|string $key, int $length, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($length) {
                return mb_strlen((string) $value) > $length;
            },
            'error' => $error,
        ];
        return $this;
    }

    public function shorter(int|string $key, int $length, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) use ($length) {
                return mb_strlen((string) $value) < $length;
            },
            'error' => $error,
        ];
        return $this;
    }

    public function email(int|string $key, string $error): self
    {
        $this->rules[$key][] = [
            'validator' => function ($value) {
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            },
            'error' => $error,
        ];
        return $this;
    }

    public function url(int|string $key, string $error): self
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
